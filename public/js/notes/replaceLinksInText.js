document.addEventListener("DOMContentLoaded", (event) => {
    document.querySelectorAll('.note-text').forEach((el) => {
        el.innerHTML = findAndReplaceLinks(el.textContent)
    })
})


function findAndReplaceLinks(text) {
    const regexUrl = /(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})/gi;
    return text.replaceAll(regexUrl, (url) => {
        return '<a href="' + url + '">' + url + '</a>';
    })
}
