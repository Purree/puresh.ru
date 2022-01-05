document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('input[type="radio"][name="notesOrderFilter"]').forEach((radio) => {
        radio.addEventListener('change', () => {
            document.querySelectorAll('.noteFilterCheckbox').forEach((toggle)=>{
                toggle.disabled = false
            })
        })
    })

    listenFilterChange(document.querySelector('#userNotesFilter'), document.querySelector('#showUserNotesFilter'))
    listenFilterChange(document.querySelector('#memberNotesFilter'), document.querySelector('#showMemberNotesFilter'))
})

function listenFilterChange(filter, toggle) {
    filter.addEventListener('change', () => {
        toggle.checked = true
        toggle.disabled = true
    })
}
