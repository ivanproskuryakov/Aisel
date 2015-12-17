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

define(['app'], function(app) {
    app.service('userService', ['$http', 'Environment', function($http, Environment) {
        return {
            register: function(form) {
                var username = form.username.$modelValue;
                var email = form.email.$modelValue;
                var password = form.password.$modelValue;
                var url = Environment.settings.api + '/user/register/';
                var data = {
                    username: username,
                    email: email,
                    password: password
                };

                return $http({
                    method: 'POST',
                    url: url,
                    data: data
                });
            },
            passwordforgot: function(form) {
                var email = form.email.$modelValue;
                var url = Environment.settings.api + '/user/password/forgot/?email=' + email;
                return $http.get(url);
            },
            signout: function() {
                var url = Environment.settings.api + '/user/logout/';
                return $http.get(url);
            },
            login: function(username, password) {
                var url = Environment.settings.api + '/user/login/';
                var data = {
                    username: username,
                    password: password
                };
                return $http({
                    method: 'POST',
                    url: url,
                    data: data
                });
            },
            getUserInformation: function() {
                var url = Environment.settings.api + '/user/information/';
                return $http.get(url);
            },

            updateAccount: function (user) {
                var url = Environment.settings.api + '/user/information/';
                var data = {
                    notification_news: user.notification_news,
                    notification_alarms: user.notification_alarms
                };
                return $http({
                    method: 'PATCH',
                    url: url,
                    data: data
                });
            },
            changePassword: function (password) {
                var url = Environment.settings.api + '/user/password/change/';
                var data = {
                    password: password
                };
                return $http({
                    method: 'PATCH',
                    url: url,
                    data: data
                });
            },
            deleteAccount: function () {
                var url = Environment.settings.api + '/user/';
                return $http({
                    method: 'DELETE',
                    url: url
                });
            },
        };
    }]);
});
