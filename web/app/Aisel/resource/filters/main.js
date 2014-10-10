'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * ...
 */

define(['app'], function (app) {
    app.filter('text', function () {
            return function (text, name) {
                return text;
            };
        }
    );
});