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

            var initInjector = angular.injector(["ng"]);
            var $http = initInjector.get("$http");

            var apiDomain = "http://api." + document.domain;
            var api = apiDomain + "/frontend/api";


            return $http
                .get(api + '/en/config/', {withCredentials: true})
                .then(function (response) {
                    var Env = response.data;

                    Env.api = api;
                    Env.media = apiDomain;
                    Env.currentLocale = function () {
                        var locale = window.location.pathname.replace(/^\/([^\/]*).*$/, '$1');
                        if (this.locale.available.indexOf(locale) == -1) {
                            locale = this.locale.primary;
                        }
                        return locale;
                    };
                    console.log(Env.currentLocale());

                    app.constant("Env", Env);
                });
        }

        fetchSettings().then(bootstrapApplication);


        function bootstrapApplication() {
            angular.bootstrap(document, ['app']);
        }

    });
});
