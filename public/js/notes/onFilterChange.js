const relationRadiosWithCheckboxes = {
    '#userNotesFilter': ['#showUserNotesFilter', {'disableOnParentClick': true, 'disableParentOnClick': true}],
    '#memberNotesFilter': ['#showMemberNotesFilter', {'disableOnParentClick': true, 'disableParentOnClick': true}],
    '#inIdOrderFilter': ['#showAllUsers', {'disableOnParentClick': false, 'disableParentOnClick': false}],
}

document.addEventListener('DOMContentLoaded', () => {

    const checkedFilters = () => {
        return document.querySelectorAll('.noteFilterCheckbox:checked')
    }


    document.querySelectorAll('input[type="radio"][name="notesOrderFilter"]').forEach((radio) => {
        radio.addEventListener('change', () => {
            document.querySelectorAll('.noteFilterCheckbox').forEach((toggle) => {
                toggle.disabled = false
            })
        })
    })

for (let relatedRadioSelector in relationRadiosWithCheckboxes) {
    let filter = document.querySelector(relatedRadioSelector)
    let relation = relationRadiosWithCheckboxes[relatedRadioSelector]

    let toggle = document.querySelector(relation[0])
    let disableElementOnParentClick = relation[1]['disableOnParentClick']
    let disableParentOnElementClick = relation[1]['disableParentOnClick']

    if (disableElementOnParentClick) {
        filter.addEventListener('change', () => {
            toggle.checked = true
            toggle.disabled = true
            })
    }

    toggle?.addEventListener('change', () => {
        document.querySelector('.apply-filters').disabled = checkedFilters().length === 0

        if (disableParentOnElementClick) {
            filter.disabled = !toggle.checked

            if (filter.checked) {
                filter.checked = false
            }
        }
        })
}
})
