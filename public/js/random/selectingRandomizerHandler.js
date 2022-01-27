import randomInteger from "./randomizer.js";

document.addEventListener('DOMContentLoaded', () => {
    let inputsCount = 2

    document.querySelector('.add-new-variant-button').onclick = (event) => {
        event.preventDefault()

        const selectingBlockExample = document.querySelector('.select-random-element-example').cloneNode(true)
        const container = document.querySelector('.selected-randomizer-container')
        inputsCount++
        selectingBlockExample.querySelector('.selecting-random-id').innerText = inputsCount
        if (!selectingBlockExample.querySelector('.delete-variant-button'))
            selectingBlockExample.querySelector('.chance-container').innerHTML += "<button class=\"btn btn-dynamic delete-variant-button\"><i class=\"bi bi-backspace\"></i></button>";

        container.appendChild(selectingBlockExample)
        updateDeleteButtons()
    }

    document.querySelector('.select-random-button').onclick = (event) => {
        event.preventDefault()

        const chances = generateChancesObject()
        const resultOutput = document.querySelector('.random-selecting-result')

        for (const [, chanceValue] of Object.entries(chances)) {
            if (parseInt(chanceValue[0]) > 10) {
                resultOutput.innerText = 'Значение шанса должно быть меньше 10'
                return;
            }
        }

        resultOutput.innerText = selectRandomVariant(chances)

            resultOutput.style = "transform: rotate(360deg); transition-duration: 0.2s;"
        setTimeout(() => {
            resultOutput.style = ""
        }, 200)

    }

    updateDeleteButtons()
})

function selectRandomVariant(chances) {
    const randomizedChances = {}
    let previousIndex

    while (true) {
        const randomizedIndex = randomInteger(0, Object.keys(chances).length-1)
        let valueOfCurrentRandomizedChance = randomizedChances[randomizedIndex]

        if (!valueOfCurrentRandomizedChance) {
            randomizedChances[randomizedIndex] = 1
        } else {
            if (previousIndex === randomizedIndex)
                randomizedChances[randomizedIndex] += 1
            else
                randomizedChances[randomizedIndex] = 1
        }

        if (parseInt(chances[String(randomizedIndex)][0]) === randomizedChances[randomizedIndex]) {
            return chances[String(randomizedIndex)][1]
        }

        previousIndex = randomizedIndex
    }
}

function updateDeleteButtons() {
    document.querySelectorAll('.delete-variant-button').forEach((button) => {
        button.onclick = (event) => {
            event.preventDefault()
            const buttonContainer = button.parentNode.parentNode.parentNode
            buttonContainer.remove()
        }
    })
}

function generateChancesObject() {
    const chances = {}
    document.querySelectorAll('.random-chance').forEach((input, iteration) => {
        const inputWord = input.parentNode.parentNode.parentNode.querySelector('.random-word').value
        const inputId = input.parentNode.parentNode.parentNode.querySelector('.selecting-random-id').innerText
        let inputValue = input.value

        if (!inputValue) {
            inputValue = 1
        }

        chances[String(iteration)] = [inputValue, inputWord, inputId]
    })
    return chances
}
