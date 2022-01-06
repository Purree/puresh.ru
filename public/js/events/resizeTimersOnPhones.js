document.addEventListener('DOMContentLoaded', () => {
    const timerClasses = [...document.querySelector('#timer').classList]
    const timerRadius = document.querySelector('#timer .base-timer__path-elapsed').getAttribute('r')
    const timerParameters = document.querySelector('#timer #base-timer-path-remaining').getAttribute('d')

    resizeTimers(timerClasses, timerRadius, timerParameters)

    window.addEventListener('resize', function() {
        resizeTimers(timerClasses, timerRadius, timerParameters)
    }, true);
})


function resizeTimers(basicTimerClasses, timerRadius, timerParameters, rollback = false) {
    if (window.innerWidth > 480) {
        document.querySelectorAll('#timer').forEach(timer => {
            timer.classList.add(...basicTimerClasses)
        })

        rollback = true
    }

    document.querySelectorAll('#timer').forEach(timer => {
        if (!rollback) timer.classList.remove("d-flex", 'mb-3')

        timer.querySelectorAll('.base-timer__circle').forEach(circle => {
            circle.querySelector('.base-timer__path-elapsed')
                .setAttribute('r', rollback ? timerRadius : '30')

            circle.querySelector('#base-timer-path-remaining')
                .setAttribute('d', rollback ? timerParameters : getReducedTimer(timer))
        })

    })
}


function getReducedTimer(timer) {
    return timer.querySelector('#base-timer-path-remaining').getAttribute('d')
        .replace('-45', '-30')
        .replace('90', '60')
        .replace('-90', '-60')
        .replaceAll('45', '30')
}
