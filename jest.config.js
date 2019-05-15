module.exports= {
    'testEnvironment': 'jest-environment-jsdom-fourteen',
    'moduleNameMapper': {
        '@/(.*)$': '<rootDir>/assets/js/src/$1',
    },
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
    'setupFilesAfterEnv': ['<rootDir>/assets/js/tests/unit/jest-setup.js']
};
