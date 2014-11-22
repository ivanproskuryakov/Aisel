// Karma configuration
// http://karma-runner.github.io/0.10/config/configuration-file.html

exports.config = {
    seleniumAddress: 'http://localhost:4444/wd/hub',
    specs: ['modules/*.js']
}
