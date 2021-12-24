document.addEventListener("DOMContentLoaded", () => {
    const PREVIEW = document.querySelector('.selectedPhotoPreview')
    const SELECTOR = document.querySelector('.selectPhoto')

    SELECTOR.onchange = () => {
        const [file] = SELECTOR.files
        if (file) {
            PREVIEW.classList.remove('d-none')
            PREVIEW.src = URL.createObjectURL(file)
        } else {
            PREVIEW.classList.add('d-none')
        }
    }
})
