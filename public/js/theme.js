if (localStorage.getItem('theme') === 'dark' || (localStorage.getItem('theme') !== 'light' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    changeTheme();
}

function changeTheme() {
    let page = document.documentElement;

    if(page.hasAttribute('data-theme')) {
        localStorage.setItem('theme', 'light');
        page.removeAttribute('data-theme');
    }
    else {
        localStorage.setItem('theme', 'dark');
        page.setAttribute('data-theme', 'dark');
    }

    document.dispatchEvent(new CustomEvent("changeTheme", {"color": localStorage.getItem("theme")}))
}
