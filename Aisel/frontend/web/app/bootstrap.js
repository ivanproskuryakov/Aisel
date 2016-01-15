'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            Aisel
 * @description     Application Bootstrap File
 */

define([
    'require',
    'angular',
    'app'
], function (require, angular, app) {
    'use strict';
    require(['domReady!'], function (document) {

        var Env = {
            media: 'http://api.' + document.domain,
            api: 'http://api.' + document.domain + '/frontend/api',
            locale: {
                "primary": 'en',
                "available": ['en', 'es', 'ru']
            },
            gremlins: {
                time: 9999 * 9999 * 9999 * 9999 * 9999,
                enabled: false
            },
            currentLocale: function () {
                var locale = window.location.pathname.replace(/^\/([^\/]*).*$/, '$1');
                if (this.locale.available.indexOf(locale) == -1) {
                    locale = this.locale.primary;
                }
                return locale;
            }
        };

        app.constant("Env", Env);
        angular.bootstrap(document, ['app']);


    });
});
