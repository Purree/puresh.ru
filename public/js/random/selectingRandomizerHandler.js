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
            selectingBlockExample.querySelector('.chance-container').innerHTML += "<button class=\"btn btn-light delete-variant-button\"><i class=\"bi bi-backspace\"></i></button>";

        container.appendChild(selectingBlockExample)
        updateDeleteButtons()
    }

    document.querySelector('.select-random-button').onclick = (event) => {
        event.preventDefault()
        const chances = generateChancesObject()

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

            // Todo: Print result into interface, limit max and min input limits
            if (parseInt(chances[String(randomizedIndex)][0]) === randomizedChances[randomizedIndex]) {
                console.log(randomizedChances, chances[String(randomizedIndex)])
                break
            }

            previousIndex = randomizedIndex
            console.log(randomizedChances, randomizedIndex)
        }
    }

    updateDeleteButtons()
})

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
        chances[String(iteration)] = [input.value, inputWord, inputId]
        // input.value
        // console.log(input.parentNode.parentNode.parentNode)
    })
    return chances
}
