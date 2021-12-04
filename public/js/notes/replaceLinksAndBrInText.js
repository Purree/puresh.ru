document.addEventListener("DOMContentLoaded", (event) => {
    startReplacement()
})

window.addEventListener('contentChanged', event => {
    startReplacement()
});

function startReplacement() {
    document.querySelectorAll('.note-text').forEach((el) => {
        el.innerHTML = findAndReplaceBr(findAndReplaceLinks(el.textContent))
    })
}

function findAndReplaceLinks(text) {
    const regexUrl = /(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})/gi;
    return text.replaceAll(regexUrl, (url) => {
        return '<a href="' + url + '">' + url + '</a>';
    })
}

function findAndReplaceBr(text) {
    const regexUrl = /<br>/gi;
    return text.replaceAll(regexUrl, () => {
        return '<br/>';
    })
}
