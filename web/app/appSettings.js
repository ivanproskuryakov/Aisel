'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * ...
 */
console.log('********************');
console.log('***** Settings *****');
console.log('********************');

aiselApp.constant('API_URL', '/api')
    .constant("LOCALE_FALLBACK", {
        "primary": 'en'
    });

aiselApp.value('appSettings', []);
