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
        var currentLocale = location.pathname.substr(1, 2);
        if (Aisel.settings.locale.available.indexOf(currentLocale) == -1) {
            window.location = "/"+ Aisel.settings.locale.primary + "/";
        }

        angular.bootstrap(document, ['app']);
    });
});