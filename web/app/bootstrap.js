'use strict';

/**
 * @ngdoc overview
 * @name Aisel
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