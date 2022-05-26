document.addEventListener("DOMContentLoaded", () => {
    startReplacement()
})

window.addEventListener('contentChanged', () => {
    startReplacement()
});

function startReplacement()
{
    document.querySelectorAll('.note-text').forEach((el) => {
        el.innerHTML = findAndReplaceBr(findAndReplaceLinks(escapeTags(el.textContent)))
    })
}

function findAndReplaceLinks(text)
{
    const regexUrl = /(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})/gi;
    return text.replaceAll(regexUrl, (url) => {
        return '<a href="' + url + '">' + url + '</a>';
    })
}

function findAndReplaceBr(text)
{
    const regexBr = /&laquo;br \/&raquo;/gi;
    return text.replaceAll(regexBr, () => {
        return '<br/>';
    })
}

function escapeTags(text)
{
    const regexSmaller =/</gi;
    const regexBigger = />/gi;
    const replaceSmallerTo = "&laquo;";
    const replaceBiggerTo = "&raquo;";

    return text.replaceAll(regexSmaller, replaceSmallerTo).replaceAll(regexBigger, replaceBiggerTo)
}
