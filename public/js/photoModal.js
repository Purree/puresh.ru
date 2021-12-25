/* https://www.w3schools.com/howto/howto_css_modal_images.asp */

document.addEventListener('contentChanged', photosModalHandler)
document.addEventListener("DOMContentLoaded", photosModalHandler)

function photosModalHandler() {

    const MODAL = document.querySelector(".image-modal");

    const IMAGES = document.querySelectorAll(".note-image");
    const MODAL_IMAGE = document.querySelector(".modal-image");
    const CAPTION_TEXT = document.querySelector(".modal-caption");
    const SPINNER = document.querySelector('.modal-image-spinner');

    IMAGES.forEach(image => {
        image.onclick = function () {
            document.body.classList.add('overflow-hidden')
            MODAL.style.display = "block";
            MODAL_IMAGE.src = this.src;

            MODAL_IMAGE.onload = () => {
                onModalImageLoad()
            }
            MODAL_IMAGE.onError = () => {
                onModalImageLoad()
                CAPTION_TEXT.innerText = 'Ошибка загрузки'
            }

            CAPTION_TEXT.innerHTML = this.alt ?? '';
        }
    })

    const MODAL_CLOSE_BUTTON = document.querySelector(".modal-close-button");

    MODAL_CLOSE_BUTTON.onclick = MODAL.onclick = (event) => {
        if (event.target !== MODAL_IMAGE) {
            MODAL.style.display = "none";
            SPINNER.classList.remove('d-none')
            MODAL_IMAGE.classList.add('d-none')
            document.body.classList.remove('overflow-hidden')
        }
    }

    function onModalImageLoad() {
        SPINNER.classList.add('d-none')
        MODAL_IMAGE.classList.remove('d-none')
    }
}
