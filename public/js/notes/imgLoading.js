document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('.imgLoading').forEach((element)=>{
        let image = element.querySelector('img')
        let imageContainer = element.querySelector('.imageBlock')
        if (image.complete) {
            onImageLoad(element, image, imageContainer)
        } else {
            element.querySelector('.spinner-border').classList.remove('d-none')
            // image.classList.add('d-none')
            imageContainer?.classList.add('d-none')
            image.onload = () => {
                onImageLoad(element, image, imageContainer)
            }
            image.onError = () => {
                image.innerText = 'Ошибка загрузки'
                onImageLoad(element, image, imageContainer)
            }
        }
    })
});

onImageLoad = (element, image, ...anotherAttributes) => {
    element.querySelector('.spinner-border').classList.add('d-none')
    // image.classList.remove('d-none')
    anotherAttributes?.forEach((attribute) => {
        attribute?.classList.remove('d-none')
    })
}
