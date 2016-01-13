'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselKernel
 * @description     Environment vars
 */

define(['angular'],
    function (angular) {
        'use strict';
        console.log('Environment loaded ...');
        angular.module('environment', [])
            .service('Environment', function () {
                var api_domain = document.domain.replace("admin", "api");

                return {
                    settings: {
                        apiSeller: 'http://' + api_domain + '/seller/api',
                        apiBackend: 'http://' + api_domain + '/backend/api',
                        api: 'http://' + api_domain + '/backend/api',
                        domain: 'http://' + api_domain,
                        pageTitle: 'Aisel - open source project | Admin',
                        locale: {
                            "primary": 'en',
                            "available": ['ru', 'es', 'en']
                        }
                    },
                    currentLocale: function () {
                        var locale = window.location.pathname.replace(/^\/([^\/]*).*$/, '$1');
                        if (this.settings.locale.available.indexOf(locale) == -1) {
                            locale = this.settings.locale.primary;
                        }
                        return locale;
                    }
                }
            })
    });
