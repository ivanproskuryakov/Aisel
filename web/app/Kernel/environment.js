'use strict';

/**
 * @ngdoc overview
 * @name Aisel
 *
 * @description
 * Environment vars
 */

var Aisel = {
    settings: {
        api: '/api',
        locale: {
            "primary": 'en',
            "available": ['en', 'es', 'ru']
        }
    },
    getLocale: function () {
        var locale = window.location.pathname.replace(/^\/([^\/]*).*$/, '$1');
        if (this.settings.locale.available.indexOf(locale) == -1) {
            locale = this.settings.locale.primary;
        }
        return locale;
    }
};