document.addEventListener('DOMContentLoaded', () => {
    const windowUnloadListener = (event) => {
        if (isFormsChanged) {
            const dialogText = 'Вы уверены, что хотите выйти? Данные в заметке могут быть не сохранены.';
            event.returnValue = dialogText;
            return dialogText;
        }
    }

    let isFormsChanged = false

    window.addEventListener('beforeunload', windowUnloadListener);

    document.querySelector('#titleEdit').onchange =
        document.querySelector('#descriptionEdit').onchange =
        changeFormStatusToTrue


    document.addEventListener('changesSaved', changeFormStatusToFalse)


    function changeFormStatusToFalse()
    {
        isFormsChanged = false
        window.removeEventListener('beforeunload', windowUnloadListener)
    }

    function changeFormStatusToTrue()
    {
        isFormsChanged = true
    }
})
