'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * Application Bootstrap File
 */

define([
    'require',
    'angular',
    'app',
], function (require, angular) {
    'use strict';

    require(['domReady!'], function (document) {
        console.log('----------- Bootstrapping the App -----------');
        angular.bootstrap(document, ['app']);
    });
});