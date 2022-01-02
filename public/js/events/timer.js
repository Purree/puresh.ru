function activateTimers() {
    document.querySelectorAll('.unused').forEach(unused => {
        unused.classList.remove('unused')

        let timer = unused.querySelector('#timer')
        const eventHappenAt = timer.dataset.happenAt
        const dateNow = () => {
            return new Date()
        };
        let dateFuture = new Date(eventHappenAt);

        if (dateFuture <= dateNow()) {
            dateFuture = dateNow()
        }

        const SECONDS_LIMIT = 60;
        const MINUTES_LIMIT = SECONDS_LIMIT;
        const HOURS_LIMIT = 24;
        const DAYS_LIMIT = new Date(new Date().getFullYear(), 1, 29).getMonth() === 1 ? 366 : 365;
        // If year is leap limit is 366 else 365


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
                    threshold: LIMITS[separator] / 2
                },
                alert: {
                    color: "red",
                    threshold: LIMITS[separator] / 4
                }
            }
        };

        let passed = {
            'seconds': LIMITS['seconds'] - getLeftTime(dateNow(), dateFuture)['seconds'],
            'minutes': LIMITS['minutes'] - getLeftTime(dateNow(), dateFuture)['minutes'],
            'hours': LIMITS['hours'] - getLeftTime(dateNow(), dateFuture)['hours'],
            'days': LIMITS['days'] - getLeftTime(dateNow(), dateFuture)['days'],
        };
        let timeLeft = {
            'seconds': LIMITS['seconds'],
            'minutes': LIMITS['minutes'],
            'hours': LIMITS['hours'],
            'days': LIMITS['days']
        };
        let timerInterval = null;

        startTimer();
        initInterval();

        function onTimesUp() {
            passed['seconds'] = 0
            timeLeft['seconds'] = LIMITS['seconds']
            insertTime();
            setRemainingPathColor(null);
            clearInterval(timerInterval);
            if (insertEverythingAndReturnIsTimerEnds()) return 'stop';
            initInterval();
        }

        function insertEverythingAndReturnIsTimerEnds() {
            // If user blur tab and current time less than event time
            if (getLeftTime(dateNow(), dateFuture)['days'] < 0) {
                return true
            }

            insertTime("seconds");
            insertTime("minutes");
            insertTime("hours");
            insertTime("days");
            return Object.values(getLeftTime(dateNow(), dateFuture)).every(el => el === 0);
        }

        function insertTime(type = "seconds") {
            timer.querySelector(`.base-timer[data-type ='${type}'] #base-timer-label`).innerHTML = getLeftTime(
                dateNow(), dateFuture
            )[type];
        }

        function initInterval() {
            timerInterval = setInterval(() => {
                startTimer()
            }, 1000);
        }

        function startTimer() {
            passed['seconds'] = passed['seconds'] += 1;
            insertEverythingAndReturnIsTimerEnds();
            updateCircles('seconds', 'minutes', 'hours', 'days')

            if (getLeftTime(dateNow(), dateFuture)['seconds'] === 0) {
                if(onTimesUp() === 'stop') {
                    stopTimer()
                }
            }
        }

        function stopTimer() {
            clearInterval(timerInterval)

            /* If tab was blurred */
            timer.querySelectorAll(`.base-timer #base-timer-label`).forEach((timer) => {
                timer.innerHTML = '0'
            })

            timer.querySelectorAll('#base-timer-path-remaining').forEach((timer) => {
                timer.setAttribute("stroke-dasharray", '-1');
            })
            /**/

            setRemainingPathColor(null);
            unused.dispatchEvent(new Event('timerStop', {'bubbles': true}))
        }

        function updateCircles(...separators) {
            separators.forEach(el => {
                setCircleDasharray(el);
                timeLeft[el] = LIMITS[el] - passed[el];
                setRemainingPathColor(timeLeft[el], el);
            })
        }

        function getLeftTime(startTime, endTime) {
            let seconds = Math.floor((endTime - (startTime)) / 1000);
            let minutes = Math.floor(seconds / 60);
            let hours = Math.floor(minutes / 60);
            let days = Math.floor(hours / 24);

            hours = hours - (days * 24);
            minutes = minutes - (days * 24 * 60) - (hours * 60);
            seconds = seconds - (days * 24 * 60 * 60) - (hours * 60 * 60) - (minutes * 60);
            return {days: days, hours: hours, minutes: minutes, seconds: seconds};
        }

        function setRemainingPathColor(timeLeft, separator = 'seconds') {
            const {alert, warning, info} = COLOR_CODES(separator);

            if (timeLeft > warning.threshold) {
                updateElementColor(alert.color, info.color, separator)
            } else if (timeLeft <= alert.threshold || timeLeft === null) {
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
            let circleDasharray = `${(
                calculateTimeFraction(separator) * FULL_DASH_ARRAY
            ).toFixed(0)}`;

            if (circleDasharray <= 0 && getLeftTime(dateNow(), dateFuture)[separator] === 0) {
                circleDasharray = -1
            }

            timer
                .querySelector(`#base-timer-path-remaining.${separator}`)
                .setAttribute("stroke-dasharray", `${circleDasharray} ${FULL_DASH_ARRAY}`);
        }

        function calculateTimeFraction(separator = 'seconds') {
            const rawTimeFraction = (timeLeft[separator] / (LIMITS[separator]));
            return rawTimeFraction - (1 / LIMITS[separator]) * (1 - rawTimeFraction);
        }
    })
}

document.addEventListener('DOMContentLoaded', activateTimers)
document.addEventListener('activateInactiveTimers', activateTimers)
document.addEventListener('updateEventStatus', event => {
    document.querySelector(`div[data-id="${event.detail.id}"]`).classList.add('unused')
})
