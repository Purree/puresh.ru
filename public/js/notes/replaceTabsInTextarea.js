document.addEventListener("DOMContentLoaded", (event) => {
    startBrReplacement()
})

window.addEventListener('contentChanged', event => {
    startBrReplacement()
});

function startBrReplacement () {
    const textArea = document.querySelector('textarea');
    let textAreaContent = textArea.value;

    textArea.value = textAreaContent
        .replaceAll('\n', '')
        .replaceAll('<br />', '\n')

}
