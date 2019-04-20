module.exports = function (api) {

    const presets = [
        ['@babel/preset-env']
    ];

    const plugins = [
        ['@babel/plugin-transform-runtime']
    ];

    if (api.env('test')) {
        plugins.push(['dynamic-import-node']);
    } else {
        plugins.push(['@babel/plugin-syntax-dynamic-import']);
    }

    api.cache(false);

    return {
        presets,
        plugins,
    };
};
