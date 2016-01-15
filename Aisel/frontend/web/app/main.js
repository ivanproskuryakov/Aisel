'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            Aisel
 * @description     Require.js launcher
 */

require.config({
    // Load paths from global variable
    paths: {
        'jQuery': '../bower_components/jquery/jquery.min',
        'underscore': '../bower_components/underscore/underscore-min',
        'domReady': '../bower_components/domReady/domReady',
        'angular': '../bower_components/angular/angular',
        'angular-resource': '../bower_components/angular-resource/angular-resource',
        'textAngular-sanitize': '../bower_components/textAngular/dist/textAngular-sanitize.min',
        'textAngular': '../bower_components/textAngular/dist/textAngular.min',
        'angular-cookies': '../bower_components/angular-cookies/angular-cookies.min',
        'angular-sanitize': '../bower_components/angular-sanitize/angular-sanitize',
        'angular-animate': '../bower_components/angular-animate/angular-animate',
        'angular-loading-bar': '../bower_components/angular-loading-bar/build/loading-bar.min',
        'ui-bootstrap-tpls': '../bower_components/angular-bootstrap/ui-bootstrap-tpls',
        'ui-validate': '../bower_components/angular-ui-validate/dist/validate.min',
        'angular-ui-router': '../bower_components/angular-ui-router/release/angular-ui-router',
        'angular-notify': '../bower_components/angular-notify/dist/angular-notify.min',
        'md5': '../bower_components/angular-gravatar/build/md5',
        'angular-gravatar': '../bower_components/angular-gravatar/build/angular-gravatar',
        'angular-disqus': '../bower_components/angular-disqus/src/angular-disqus',
        'twitter-bootstrap': '../bower_components/sass-bootstrap/dist/js/bootstrap'
    },
    // Add angular modules that does not support AMD out of the box, put it in a shim
    shim: {
        'angular-loading-bar': ['angular'],
        'angular-animate': ['angular'],
        'angular-ui-router': ['angular'],
        'angular': {
            'exports': 'angular',
            deps: ['jQuery']
        },
        'jQuery': {
            'exports': 'jQuery'
        },
        "domReady": ["angular"],
        "angular-resource": ["angular"],
        "textAngular": ["angular"],
        "angular-cookies": ["angular"],
        "ui-bootstrap-tpls": ["angular"],
        "twitter-bootstrap": ["angular"],
        "angular-disqus": ["angular"],
        "angular-notify": ["angular"],
        "angular-gravatar": ["angular"],
        "angular-sanitize": ["angular"],
        "ui-validate": ["angular"],
        "md5": ["angular"]
    },
    // Kick start application
    deps: [
        './Aisel/Kernel/AiselKernel',
        './Aisel/Homepage/AiselHomepage',
        './Aisel/Contact/AiselContact',
        './Aisel/Search/AiselSearch',
        './Aisel/Page/AiselPage',
        './Aisel/Product/AiselProduct',
        './Aisel/Review/AiselReview',
        './Aisel/User/AiselUser',
        './Aisel/Cart/AiselCart',
        './Aisel/Order/AiselOrder',
        './Aisel/Exception/AiselException',
        'bootstrap'
    ],
    priority: [
        "angular"
    ]
});
