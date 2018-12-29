export const isBase64 = (str) => {
    try {
        atob(str);
        return true;
    } catch (e) {
        return false;
    }
};