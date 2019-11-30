const importTransforms = {
    'rxjs/observable': {
        transform: 'rxjs/_esm5/internal/observable/${member}',
        preventFullImport: true,
        skipDefaultConversion: true,
    },
};

module.exports = function (api) {

    const presets = [
        ['@babel/preset-env', {
            targets: {node: 'current'},
            useBuiltIns: 'usage',
            corejs: 3
        }]
    ];

    const plugins = [
        ['@babel/plugin-proposal-function-bind'],
        ['@babel/plugin-proposal-class-properties', { loose: false }],
        '@babel/plugin-proposal-export-default-from',
        ['transform-imports', importTransforms],
    ];

    if (api.env('test')) {
        plugins.push(['dynamic-import-node']);
    } else {
        plugins.push(['@babel/plugin-transform-runtime']);
    }


    return {
        presets,
        plugins,
    };
};
