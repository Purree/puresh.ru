document.addEventListener("DOMContentLoaded", (event) => {
    document.querySelectorAll('.imgLoading').forEach((element)=>{
        let image = element.querySelector('img')
        image.onload = () => {
            element.querySelector('.spinner-border').classList.add('d-none')
            image.classList.remove('d-none')
        }
    })
});
