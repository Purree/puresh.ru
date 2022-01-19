document.addEventListener('DOMContentLoaded', () => {
    window.onbeforeunload = (event) => {
        const dialogText = 'Вы уверены, что хотите выйти? Данные в заметке могут быть не сохранены.';
        event.returnValue = dialogText;
        return dialogText;
    };
})
