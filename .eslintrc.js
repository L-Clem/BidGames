const { ESLint } = require("eslint");

module.exports = {
    extends: ['eslint:recommended', 'plugin:react/recommended'],
    parserOptions: {
        parser: "babel-eslint",
        ecmaVersion: 6,
        sourceType: 'module',
        ecmaFeatures: {
            jsx: true
        }
    },
    env: {
        browser: true,
        es6: true,
        node: true
    },
    rules: {
        "no-console": 0,
        "no-unused-vars": 0,
        "react/prop-types": "off"
    },
    settings: {
        react: {
            version: 'detect',
        }
    }
};