function isBrowserSupport() {
    try {
        '       1234'.trimStart()
    } catch (e) {
        return false;
    }
    return true;
}
