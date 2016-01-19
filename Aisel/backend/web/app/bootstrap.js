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
    'app',
], function (require, angular, app) {
    'use strict';
    require(['domReady!'], function (document) {

        function fetchSettings() {

            var $http = angular.injector(["ng"]).get("$http");

            var api_domain = document.domain.replace("admin", "api");


            return $http
                .get("http://" + api_domain + "/frontend/api/user/information/", {withCredentials: true})
                .then(function (response) {

                    var Env = {
                        api: 'http://' + api_domain + '/backend/api',

                        apiBackend: 'http://' + api_domain + '/backend/api',
                        apiFrontend: 'http://' + api_domain + '/frontend/api',
                        apiSeller: 'http://' + api_domain + '/seller/api',

                        domain: 'http://' + api_domain,
                        pageTitle: 'Aisel | Admin',
                        locale: {
                            "primary": 'en',
                            "available": ['ru', 'es', 'en']
                        },
                        currentLocale: function () {
                            var locale = window.location.pathname.replace(/^\/([^\/]*).*$/, '$1');
                            if (this.locale.available.indexOf(locale) == -1) {
                                locale = this.locale.primary;
                            }
                            return locale;
                        }
                    };

                    if (response.data.roles === 'ROLE_USER') {
                        Env.api = Env.apiSeller;
                    }
                    if (response.data.roles === 'ROLE_ADMIN') {
                        Env.api = Env.apiBackend;
                    }

                    app.constant("Env", Env);
                });
        }

        fetchSettings().then(bootstrapApplication);


        function bootstrapApplication() {
            angular.bootstrap(document, ['app']);
        }


    });
});
