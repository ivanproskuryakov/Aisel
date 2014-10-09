'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * Application core module
 */

define([
    'require',
    'angular',
    'app',
    './appEnvironment',
    './appRouter',
    './Aisel/resource/services/root',
    './Aisel/homepage/router',
    './Aisel/homepage/controllers/homepage'
], function (require, angular) {
    'use strict';

    require(['domReady!'], function (document) {
        console.log('----------- Bootstrapping the App -----------');
        angular.bootstrap(document, ['app']);
    });
});