'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselUser
 * @description     ...
 */

define(['app'], function (app) {
    app.service('userService', ['$http', 'Environment', function ($http, Environment) {
        return {
            passwordforgot: function (form) {
                var email = form.email.$modelValue;
                var url = Environment.settings.api + '/user/passwordforgot.json?email=' + email;
                console.log(url);
                return $http.get(url);
            },
            signout: function () {
                var url = Environment.settings.api + '/user/logout.json';
                console.log(url);
                return $http.get(url);
            },
            login: function (username, password) {
                var url = Environment.settings.api + '/user/login.json?username=' + username + '&password=' + password;
                console.log(url);
                return $http.get(url);
            },
            getUserInformation: function () {
                var url = Environment.settings.api + '/user/information.json';
                // console.log(url);
                return $http.get(url);
            }
        };
    }]);
});