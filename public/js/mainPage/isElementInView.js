export function isElementInView(element) {
    const elementData = element.getBoundingClientRect();
    const elementHeight = elementData['height']
    const elementY = elementData['y']
    return (elementHeight + elementY) > 0 && (elementY < window.innerHeight)
}
