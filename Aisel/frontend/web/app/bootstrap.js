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

        function fetchSettings() {

            var $http = angular.injector(["ng"]).get("$http");
            var api = "http://api." + document.domain + "/frontend/api";
            var locale = window.location.pathname.replace(/^\/([^\/]*).*$/, '$1');

            if (locale == "") {
                locale = 'en';
            }

            return $http.get(api + '/' + locale + '/config/', {withCredentials: true})
                .then(function (response) {
                    var Env = response.data;

                    Env.api = api;
                    Env.media = "http://api." + document.domain;
                    Env.currentLocale = function () {
                        if (this.locale.available.indexOf(locale) == -1) {
                            locale = this.locale.primary;
                        }
                        return locale;
                    };
                    app.constant("Env", Env);
                });
        }

        fetchSettings().then(bootstrapApplication);


        function bootstrapApplication() {
            angular.bootstrap(document, ['app']);
        }

    });
});
