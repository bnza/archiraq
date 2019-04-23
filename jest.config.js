module.exports= {
    'testEnvironment': 'jest-environment-jsdom-fourteen',
    'moduleFileExtensions': [
        'js',
        'json',
        'vue'
    ],
    'transform': {
        '.*\\.(vue)$': 'vue-jest',
        '^.+\\.jsx?$': 'babel-jest'
    },
    'transformIgnorePatterns': [
        'node_modules/(?!(ol|vuelayers|@babel)/)'
    ],
    'roots': [
        '<rootDir>/assets/js/tests/unit/'
    ],
    'setupFiles': [
        'jest-canvas-mock', // <- the new mock
    ],
    'setupTestFrameworkScriptFile': '<rootDir>/assets/js/tests/unit/jest-setup.js'
};
