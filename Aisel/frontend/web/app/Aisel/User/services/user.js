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
    app.service('userService',
        ['$http', 'Environment',
            function ($http, Environment) {
                return {
                    register: function (email, password) {
                        var url = Environment.settings.api + '/user/register/';
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
                    passwordforgot: function (form) {
                        var email = form.email.$modelValue;
                        var url = Environment.settings.api + '/user/password/forgot/?email=' + email;
                        return $http.get(url);
                    },
                    signout: function () {
                        var url = Environment.settings.api + '/user/logout/';
                        return $http.get(url);
                    },
                    login: function (email, password) {
                        var url = Environment.settings.api + '/user/login/';
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
                        var url = Environment.settings.api + '/user/information/';
                        return $http.get(url);
                    },
                    updateAccount: function (user) {
                        var url = Environment.settings.api + '/user/information/';
                        var data = {
                            phone: user.phone,
                            about: user.about,
                            website: user.website,
                            facebook: user.facebook,
                            twitter: user.twitter
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
                    }
                };
            }]);
});
