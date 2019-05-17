module.exports = function (api) {

    const presets = [
        ['@babel/preset-env', {
            useBuiltIns: 'usage',
            corejs: 3
        }]
    ];

    const plugins = [
        ['@babel/plugin-transform-runtime']
    ];

    if (api.env('test')) {
        plugins.push(['dynamic-import-node']);
    }

    api.cache(false);

    return {
        presets,
        plugins,
    };
};
