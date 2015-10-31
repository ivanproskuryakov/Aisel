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
                console.log(url);

                return $http({
                    method: 'POST',
                    url: url,
                    data: data
                });
            },
            editDetails: function(form) {
                var formData = {};
                formData['about'] = encodeURIComponent(form.about.$modelValue);
                formData['phone'] = encodeURIComponent(form.phone.$modelValue);
                formData['website'] = encodeURIComponent(form.website.$modelValue);
                formData['facebook'] = encodeURIComponent(form.facebook.$modelValue);
                formData['linkedin'] = encodeURIComponent(form.linkedin.$modelValue);
                formData['twitter'] = encodeURIComponent(form.twitter.$modelValue);
                formData['googleplus'] = encodeURIComponent(form.googleplus.$modelValue);
                formData['github'] = encodeURIComponent(form.github.$modelValue);
                formData['behance'] = encodeURIComponent(form.behance.$modelValue);
                formData['googleplus'] = encodeURIComponent(form.googleplus.$modelValue);

                var userData = JSON.stringify(formData);
                var url = Environment.settings.api + '/user/edit/?userdata=' + userData;
                console.log(url);
                return $http.get(url);
            },
            passwordforgot: function(form) {
                var email = form.email.$modelValue;
                var url = Environment.settings.api + '/user/password/forgot/?email=' + email;
                console.log(url);
                return $http.get(url);
            },
            signout: function() {
                var url = Environment.settings.api + '/user/logout/';
                console.log(url);
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
                console.log(url);
                return $http.get(url);
            }
        };
    }]);
});
