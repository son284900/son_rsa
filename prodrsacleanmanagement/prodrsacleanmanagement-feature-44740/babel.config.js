// babel.config.js
module.exports = api => {
    // eslint-disable-next-line no-unused-vars
    const isTest = api.env("test");

    return {
        presets: [
            [
                "@babel/preset-env",
                {
                    targets: {
                        node: "current"
                    }
                }
            ]
        ]
    };
};
