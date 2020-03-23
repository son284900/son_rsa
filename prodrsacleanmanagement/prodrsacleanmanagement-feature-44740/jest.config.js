// jest.config.js
module.exports = {
    testRegex: "resources/js/components/*/.*.spec.js$",
    moduleNameMapper: {
        "@/(.*)$": "<rootDir>/resources/$1"
    },
    moduleFileExtensions: [
        "js",
        "vue"
    ],
    transform: {
        "^.+\\.js$": "<rootDir>/node_modules/babel-jest",
        ".*\\.(vue)$": "<rootDir>/node_modules/vue-jest"
    },
    snapshotSerializers: ["jest-serializer-vue"],
    collectCoverageFrom: ["resources/js/components/**/*.{js,jsx,ts,tsx,vue}"],
    collectCoverage: true,
    coverageReporters: ["html", "text-summary"],
    coverageDirectory: "./coverage/frontend/"
};
