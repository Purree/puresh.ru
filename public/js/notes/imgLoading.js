document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('.imgLoading').forEach((element)=>{
        let image = element.querySelector('img')
        if (image.complete) {
            onImageLoad(element, image)
        } else {
            image.onload = () => {
                onImageLoad(element, image)
            }
            image.onError = () => {
                image.innerText = 'Ошибка загрузки'
                onImageLoad(element, image)
            }
        }
    })
});

onImageLoad = (element, image) => {
    element.querySelector('.spinner-border').classList.add('d-none')
    image.classList.remove('d-none')
}
