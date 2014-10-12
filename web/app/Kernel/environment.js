'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * Environment vars
 */

var Aisel = {
    settings: {
        api: '/api',
        locale: {
            "primary": 'en'
        }
    },
    paths: {
        'jquery: ': '../bower_components/jquery/jquery',
        'domReady': '../bower_components/domReady/domReady',
        'angular': '../bower_components/angular/angular',
        'twitter-bootstrap': '../bower_components/sass-bootstrap/dist/js/bootstrap',
        'angular-resource': '../bower_components/angular-resource/angular-resource',
        'textAngular-sanitize': '../bower_components/textAngular/dist/textAngular-sanitize.min',
        'textAngular': '../bower_components/textAngular/dist/textAngular.min',
        'angular-cookies': '../bower_components/angular-cookies/angular-cookies.min',
        'angular-sanitize': '../bower_components/angular-sanitize/angular-sanitize',
        'angular-route': '../bower_components/angular-route/angular-route',
        'ui-bootstrap-tpls': '../bower_components/angular-bootstrap/ui-bootstrap-tpls',
        'ui-utils': '../bower_components/angular-ui-utils/ui-utils',
        'angular-notify': '../bower_components/angular-notify/dist/angular-notify.min',
        'md5': '../bower_components/angular-gravatar/build/md5',
        'angular-gravatar': '../bower_components/angular-gravatar/build/angular-gravatar',
        'angular-disqus': '../bower_components/angular-disqus/src/angular-disqus',
    },
    bundles: [
        './Kernel/router',
        './Kernel/services/root',
        './Kernel/services/init',
        './Kernel/services/auth',
        './Aisel/Homepage/AiselHomepage',
        './Aisel/Contact/AiselContact',
        './Aisel/Search/AiselSearch',
        './Aisel/Page/AiselPage',
        './Aisel/User/AiselUser',
    ]
};