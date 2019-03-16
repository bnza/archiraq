export const getNamespacedStoreProp = (namespace, prop) => `${namespace}/${prop}`;

export const randomInt = (max = 1000) => {
    return Math.floor(Math.random() * (max));
};

export const getDataTestSelector = (value) => `[data-test="${value}"]`;
