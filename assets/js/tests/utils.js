export const silenziateLocalVueDuplicateVueBug = () => {
    const logError = console.error;
    console.error = (...args) => {
        if (
            args[0].includes("[Vuetify]") &&
            args[0].includes("https://github.com/vuetifyjs/vuetify/issues/4068")
        )
            return;
        logError(...args);
    };
    return logError;
}

export const resetConsoleError = (logError) => {
    console.error = logError
}
