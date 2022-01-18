document.addEventListener('DOMContentLoaded', () => {
    let isFormsChanged = false

    window.onbeforeunload = (event) => {
        if (isFormsChanged) {
            const dialogText = 'Вы уверены, что хотите выйти? Данные в заметке могут быть не сохранены.';
            event.returnValue = dialogText;
            return dialogText;
        }
    };

    document.querySelector('#titleEdit').onchange = document.querySelector('#descriptionEdit').onchange =
        isFormsChanged = true

    document.addEventListener('changesSaved', () => {
        isFormsChanged = false
    })
})
