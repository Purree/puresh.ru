document.querySelectorAll('#timer').forEach(timer => {
    const TIME_LIMIT = 60;
    const FULL_DASH_ARRAY = 283;
    const WARNING_THRESHOLD = TIME_LIMIT/2;
    const ALERT_THRESHOLD = TIME_LIMIT/4;

    const COLOR_CODES = {
        info: {
            color: "green"
        },
        warning: {
            color: "orange",
            threshold: WARNING_THRESHOLD
        },
        alert: {
            color: "red",
            threshold: ALERT_THRESHOLD
        }
    };

    let eventHappenAt = timer.dataset.happenAt
    let dateFuture = new Date(eventHappenAt);
    let dateNow = new Date();



// let timePassed = 60 - getLeftTime(dateNow, dateFuture)['seconds'];
    let timePassed = 0;
    let timeLeft = TIME_LIMIT;
    let timerInterval = null;


    setRemainingPathColor(null);

    startTimer();

    function onTimesUp() {
        timePassed = 0
        timeLeft = TIME_LIMIT
        insertTime();
        setCircleDasharray();
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
        if(insertEverythingAndReturnIsItsLastDay()) return 'stop'
        timerInterval = setInterval(() => {
            timePassed = timePassed += 1;
            timeLeft = TIME_LIMIT - timePassed;
            dateNow.setSeconds(dateNow.getSeconds() + 1);
            insertEverythingAndReturnIsItsLastDay();
            setCircleDasharray();
            setRemainingPathColor(timeLeft);

            if (getLeftTime(dateNow, dateFuture)['seconds'] === 0) {
                onTimesUp();
            }
        }, 1000);
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

    function updateElementColor(removedColor, addedColor, elementId = "base-timer-path-remaining") {
        timer
            .querySelector(`#${elementId}`)
            .classList.remove(removedColor);
        timer
            .querySelector(`#${elementId}`)
            .classList.add(addedColor);
    }

    function setRemainingPathColor(timeLeft) {
        const {alert, warning, info} = COLOR_CODES;
        if (timeLeft === null) {
            updateElementColor(alert.color, info.color)
        } else if (timeLeft <= alert.threshold) {
            updateElementColor(warning.color, alert.color)
        } else if (timeLeft <= warning.threshold) {
            updateElementColor(info.color, warning.color)
        }
    }

    function calculateTimeFraction() {
        const rawTimeFraction = (timeLeft / TIME_LIMIT);
        return rawTimeFraction - (1 / TIME_LIMIT) * (1 - rawTimeFraction);
    }

    function setCircleDasharray() {
        const circleDasharray = `${(
            calculateTimeFraction() * FULL_DASH_ARRAY
        ).toFixed(0)} 283`;
        timer
            .querySelector("#base-timer-path-remaining")
            .setAttribute("stroke-dasharray", circleDasharray);
    }
})
