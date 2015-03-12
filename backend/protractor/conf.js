// Karma configuration
// http://karma-runner.github.io/0.10/config/configuration-file.html

exports.config = {
    seleniumAddress: 'http://localhost:4444/wd/hub',
    specs: [
        'modules/auth.js',
        'modules/dashboard.js',
        'modules/addressing.js',
        'modules/backendUser.js',
        'modules/frontendUser.js',
        'modules/orders.js',
        'modules/products.js',
        'modules/products.js',
        'modules/page.js',
    ]
}
