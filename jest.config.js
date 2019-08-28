module.exports= {
    'testEnvironment': 'jest-environment-jsdom-fourteen',
    'moduleNameMapper': {
        '@/(.*)$': '<rootDir>/assets/js/src/$1',
        '@tests/(.*)$': '<rootDir>/assets/js/tests/$1',
        '^ol-tilecache$': 'ol-tilecache/dist/bundle.es.js'
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
        'node_modules/(?!(ol|ol-tilecache|vuelayers|@babel|rxjs|vee-validate)/)'
    ],
    'roots': [
        '<rootDir>/assets/js/tests/unit/'
    ],
    'setupFiles': [
        'jest-canvas-mock', // <- the new mock
    ],
    'setupFilesAfterEnv': ['<rootDir>/assets/js/tests/unit/jest-setup.js']
};
