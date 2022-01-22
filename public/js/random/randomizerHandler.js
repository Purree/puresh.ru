import randomInteger from "./randomizer.js"

document.addEventListener('DOMContentLoaded', () => {
    const generateButton = document.querySelector('.generate-random-number-button');
    const generateButtonText = generateButton.innerText;
    const randomFromElement = document.querySelector('#randomFrom');
    const randomToElement = document.querySelector('#randomTo');

    let animationTimeout;
    let changeButtonTimeouts = [];


    generateButton.onclick = (event) => {
        const randomFrom = parseInt(randomFromElement.value);
        const randomTo = parseInt(randomToElement.value);

        event.preventDefault();

        if (!randomFormValidation(randomFrom, randomTo, randomFromElement, randomToElement, changeButtonTimeouts, generateButton, generateButtonText))
            return;



        const randomOutput = document.querySelector('.random-result')

        randomOutput.style = "transform: rotate(360deg); transition-duration: 0.2s;"
        if (animationTimeout) {
            clearTimeout(animationTimeout)
        }

        animationTimeout = setTimeout(() => {
            randomOutput.style = ""
        }, 200)

            randomOutput.innerText =
                randomInteger(
                    randomFrom,
                    randomTo
                );
    }
    randomInteger(1, 5);
})

function randomFormValidation (randomFrom, randomTo, randomFromElement, randomToElement, changeButtonTimeouts, generateButton, generateButtonText) {
    if (!validateInput(randomFrom, randomFromElement)) return false;
    if (!validateInput(randomTo, randomToElement)) return false;

    if (randomFrom >= randomTo) {
        if (changeButtonTimeouts[0]) {
            clearTimeout(changeButtonTimeouts[0]);
        }

        changeButtonTimeouts[0] = setTimeout(() => {
            generateButton.innerText = generateButtonText
        }, 2000);

        if (changeButtonTimeouts[1]) {
            clearTimeout(changeButtonTimeouts[1]);
        }

        generateButton.style = "animation: shake 0.5s; animation-iteration-count: 10; background-color: red; border-color: red";
        changeButtonTimeouts[1] = setTimeout(() => {
            generateButton.style = ""
        }, 300);

        generateButton.innerText = 'Значение в "От" должно быть меньше значения в "До"';
        return false;
    }
    return true;
}

function validateInput(inputValue, input) {
    if (!inputValue) {
        input.classList.add('is-invalid');
        return false;
    } else {
        input.classList.remove('is-invalid');
        return true;
    }
}
