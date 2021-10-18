document.querySelectorAll('#timer').forEach(timer => {
    const eventHappenAt = timer.dataset.happenAt
    const dateNow = new Date();
    let dateFuture = new Date(eventHappenAt);

    if (dateFuture <= dateNow) {
        dateFuture = dateNow
    }

    const SECONDS_LIMIT = 60;
    const MINUTES_LIMIT = SECONDS_LIMIT;
    const HOURS_LIMIT = 24;
    const DAYS_LIMIT =
        Math.ceil(
                getLeftTime(dateNow, dateFuture)['days']/365
            ) * 365;

    const LIMITS = {
        'seconds': SECONDS_LIMIT,
        'minutes': MINUTES_LIMIT,
        'hours': HOURS_LIMIT,
        'days': DAYS_LIMIT
    };
    const FULL_DASH_ARRAY = 283;

    const COLOR_CODES = (separator = 'seconds') => {
        return {
            info: {
                color: "green"
            },
            warning: {
                color: "orange",
                threshold: LIMITS[separator]/2
            },
            alert: {
                color: "red",
                threshold: LIMITS[separator]/4
            }
        }};

    let passed = {
        'seconds': LIMITS['seconds'] - getLeftTime(dateNow, dateFuture)['seconds'],
        'minutes': LIMITS['minutes'] - getLeftTime(dateNow, dateFuture)['minutes'],
        'hours': LIMITS['hours'] - getLeftTime(dateNow, dateFuture)['hours'],
        'days': LIMITS['days'] - getLeftTime(dateNow, dateFuture)['days'],
    };
    let timeLeft = {
        'seconds': LIMITS['seconds'],
        'minutes': LIMITS['minutes'],
        'hours': LIMITS['hours'],
        'days': LIMITS['days']
    };
    let timerInterval = null;

    startTimer();

    function onTimesUp() {
        if(passed['minutes'] === LIMITS['minutes']){
            passed['minutes'] = 0
        }
        if(passed['hours'] === LIMITS['hours']){
            passed['hours'] = 0
        }
        if(passed['days'] === LIMITS['days']){
            passed['days'] = 0
        }

        passed['seconds'] = 0
        timeLeft['seconds'] = LIMITS['seconds']
        insertTime();
        setRemainingPathColor(null);
        clearInterval(timerInterval);
        if(insertEverythingAndReturnIsItsLastDay()) return 'stop';
        startTimer();
    }

    function insertEverythingAndReturnIsItsLastDay() {
        insertTime("seconds");
        insertTime("minutes");
        insertTime("hours");
        insertTime("days");
        return Object.values(getLeftTime(dateNow, dateFuture)).every(el => el === 0);
    }

    function insertTime(type = "seconds") {
        timer.querySelector(`.base-timer[data-type ='${type}'] #base-timer-label`).innerHTML = getLeftTime(
            dateNow, dateFuture
        )[type];
    }

    function startTimer() {
        if(insertEverythingAndReturnIsItsLastDay()) return 'stop';

        timerInterval = setInterval(() => {
            passed['seconds'] = passed['seconds'] += 1;
            dateNow.setSeconds(dateNow.getSeconds() + 1);
            insertEverythingAndReturnIsItsLastDay();
            updateCircles('seconds', 'minutes', 'hours', 'days')
            if (getLeftTime(dateNow, dateFuture)['seconds'] === 0) {
                onTimesUp();
            }
        }, 1000);
    }


    function updateCircles(...separators) {
        separators.forEach(el => {
            setCircleDasharray(el);
            timeLeft[el] = LIMITS[el] - passed[el];
            setRemainingPathColor(timeLeft[el], el);
        })
    }

    function getLeftTime(startTime, endTime) {
        let seconds = Math.floor((endTime - (startTime))/1000);
        let minutes = Math.floor(seconds/60);
        let hours = Math.floor(minutes/60);
        let days = Math.floor(hours/24);

        hours = hours-(days*24);
        minutes = minutes-(days*24*60)-(hours*60);
        seconds = seconds-(days*24*60*60)-(hours*60*60)-(minutes*60);
        return {days: days, hours: hours, minutes: minutes, seconds: seconds};
    }

    function setRemainingPathColor(timeLeft, separator = 'seconds') {
        const {alert, warning, info} = COLOR_CODES(separator);
        if (timeLeft > warning.threshold) {
            updateElementColor(alert.color, info.color, separator)
        } else if (timeLeft <= alert.threshold) {
            updateElementColor(warning.color, alert.color, separator)
        } else if (timeLeft <= warning.threshold) {
            updateElementColor(info.color, warning.color, separator)
        }
    }

    function updateElementColor(removedColor, addedColor, separator = "seconds") {
        timer
            .querySelector(`#base-timer-path-remaining.${separator}`)
            .classList.remove(removedColor);
        timer
            .querySelector(`#base-timer-path-remaining.${separator}`)
            .classList.add(addedColor);
    }

    function setCircleDasharray(separator = 'seconds') {
        const circleDasharray = `${(
            calculateTimeFraction(separator) * FULL_DASH_ARRAY
        ).toFixed(0)} ${FULL_DASH_ARRAY}`;
        timer
            .querySelector(`#base-timer-path-remaining.${separator}`)
            .setAttribute("stroke-dasharray", circleDasharray);
    }

    function calculateTimeFraction(separator = 'seconds') {
        const rawTimeFraction = (timeLeft[separator] / LIMITS[separator]);
        return rawTimeFraction - (1 / LIMITS[separator]) * (1 - rawTimeFraction);
    }
})
