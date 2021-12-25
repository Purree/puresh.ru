document.addEventListener("DOMContentLoaded", () => {
    const SELECTOR = document.querySelector('.selectPhoto')

    SELECTOR.onchange = () => {
        const [file] = SELECTOR.files
        const PREVIEW = document.querySelector('.selectedPhotoPreview')
        if (file) {
            PREVIEW.classList.remove('d-none')
            PREVIEW.src = URL.createObjectURL(file)
        } else {
            PREVIEW.classList.add('d-none')
        }
    }
})

document.addEventListener('imageUploaded', () => {
    document.querySelector('button[data-bs-dismiss="modal"]').click()
})
