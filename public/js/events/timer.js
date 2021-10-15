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

let dateFuture = new Date('2022-06-12 15:23:16');
let dateNow = new Date();
console.log(dateNow, dateFuture)
let seconds = Math.floor((dateFuture - (dateNow))/1000);
let minutes = Math.floor(seconds/60);
let hours = Math.floor(minutes/60);
let days = Math.floor(hours/24);

hours = hours-(days*24);
minutes = minutes-(days*24*60)-(hours*60);
seconds = seconds-(days*24*60*60)-(hours*60*60)-(minutes*60);
console.log(days, hours, minutes, seconds)





let timePassed = 0;
let timeLeft = TIME_LIMIT;
let timerInterval = null;
let remainingPathColor = COLOR_CODES.info.color;

document.getElementById('base-timer-path-remaining').classList += " " + remainingPathColor;

startTimer();

function onTimesUp() {
    timePassed = 0
    timeLeft = TIME_LIMIT
    insertTime();
    setCircleDasharray();
    setRemainingPathColor(null);
    clearInterval(timerInterval);
    startTimer();
}

function insertTime() {
    document.getElementById("base-timer-label").innerHTML = formatTime(
        timeLeft
    );
}

function startTimer() {
    timerInterval = setInterval(() => {
        timePassed = timePassed += 1;
        timeLeft = TIME_LIMIT - timePassed;
        insertTime();
        setCircleDasharray();
        setRemainingPathColor(timeLeft);

        if (timeLeft === 0) {
            onTimesUp();
        }
    }, 1000);
}

function formatTime(time) {
    // const minutes = Math.floor(time / 60);
    let seconds = time % 60;

    if (seconds < 10) {
        seconds = `0${seconds}`;
    }

    return `${seconds}`;
}

function updateElementColor(removedColor, addedColor, elementId = "base-timer-path-remaining") {
    document
        .getElementById(elementId)
        .classList.remove(removedColor);
    document
        .getElementById(elementId)
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
    document
        .getElementById("base-timer-path-remaining")
        .setAttribute("stroke-dasharray", circleDasharray);
}
