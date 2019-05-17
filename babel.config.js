module.exports = function (api) {

    const presets = [
        ['@babel/preset-env', {
            useBuiltIns: 'usage',
            corejs: 3
        }]
    ];

    const plugins = [];

    if (api.env('test')) {
        plugins.push(['dynamic-import-node']);
    } else {
        plugins.push(['@babel/plugin-transform-runtime']);
    }

    api.cache(false);

    return {
        presets,
        plugins,
    };
};
