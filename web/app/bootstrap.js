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
        angular.bootstrap(document, ['app']);
    });
});