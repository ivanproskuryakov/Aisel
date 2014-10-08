'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * ...
 */
define(['app'], function (app) {
    console.log('************************************');
    console.log('***** App Environment Settings *****');
    console.log('************************************');

    app.constant('API_URL', '/api')
        .constant("LOCALE_FALLBACK", {
            "primary": 'en'
        });
});