'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * ...
 */

console.log('************************************');
console.log('***** App Environment Settings *****');
console.log('************************************');

aiselApp.constant('API_URL', '/api')
    .constant("LOCALE_FALLBACK", {
        "primary": 'en'
    });
