'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselAuth
 * @description     ...
 */

define(['app'], function (app) {
    app.service('authService', ['$http', 'Env', function ($http, Env) {
        return {
            signout: function () {
                var url = Env.apiFrontend + '/user/logout/';
                console.log(url);
                return $http.get(url);
            },
            login: function (email, password) {
                var url = Env.apiFrontend + '/user/login/';
                var data = {
                    email: email,
                    password: password
                };

                return $http({
                    method: 'POST',
                    url: url,
                    data: data
                });
            },
            getUserInformation: function () {
                var url = Env.apiFrontend + '/user/information/';
                // console.log(url);
                return $http.get(url);
            }
        };
    }]);
});
