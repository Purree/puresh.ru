const relationRadiosWithCheckboxes = {
    '#userNotesFilter': ['#showUserNotesFilter', {'disableParentOnClick': true}],
    '#memberNotesFilter': ['#showMemberNotesFilter', {'disableParentOnClick': true}],
    '#inIdOrderFilter': ['#showAllUsers', {'disableParentOnClick': false}],
}

document.addEventListener('DOMContentLoaded', () => {

    const checkedFilters = () => {
        return document.querySelectorAll('.noteFilterCheckbox:checked')
    }

    for (let relatedRadioSelector in relationRadiosWithCheckboxes) {
        const filter = document.querySelector(relatedRadioSelector)
        const relation = relationRadiosWithCheckboxes[relatedRadioSelector]
        const filterParent = document.querySelector(relatedRadioSelector).parentElement

        const toggle = document.querySelector(relation[0])
        const disableParentOnElementClick = relation[1]['disableParentOnClick']

        const filterId = '#' + filter.id;
        if (filterId in relationRadiosWithCheckboxes && relationRadiosWithCheckboxes[filterId][1]['disableParentOnClick']) {
            toggleElement(filterParent, document.querySelector(relationRadiosWithCheckboxes[filterId][0]).checked)
        }

        toggle?.addEventListener('change', () => {
            toggleElement(document.querySelector('.apply-filters'), checkedFilters().length !== 0)

            if (disableParentOnElementClick) {
                toggleElement(filterParent, toggle.checked)

                filter.checked = false
            }
        })
    }
})

function toggleElement(element, enable = null)
{
    if (enable !== null) {
        return element.classList.toggle('disabled', !enable)
    }

    return element.classList.toggle('disabled')
}
