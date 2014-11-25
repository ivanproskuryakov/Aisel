'use strict';

/**
 * @ngdoc overview
 * @name Aisel
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