'use strict';

/**
 * @ngdoc overview
 *
 * @name aiselApp
 *
 * @description
 *
 * ...
 */

angular.module('aiselApp')
    .filter('text', function () {
        return function (text, name) {
            return text;
        };
    }
);
