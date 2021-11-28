import {isElementInView} from "./isElementInView.js";


const allIds = [...document.querySelectorAll('.nav-link[data-id]')].map(el => el.dataset.id)

setInterval(() => {
        const activeIds = [];

        // Check is element on user screen, if its true, add active class to element and push it into active elements
        document.querySelectorAll('.informationSection').forEach((element) => {
            if (isElementInView(element)) {
                const activeElement = document.querySelector(`.nav-link[data-id="${element.dataset.id}"]`);
                activeElement.classList.add('active');
                activeIds.push(activeElement.dataset.id)
            }
        })

        // Find difference between two arrays and remove the 'active' class if its exist
        allIds.filter(id => !activeIds.includes(id)).forEach((id) => {
            document.querySelector(`.nav-link[data-id="${id}"].active`)?.classList.remove('active')
        })

    },
    1000
)
