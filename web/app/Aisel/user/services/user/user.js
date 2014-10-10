'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * ...
 */

define(['app'], function (app) {
    app.service('userService', ['$http', '$routeParams', 'API_URL', function ($http, $routeParams, API_URL) {
        return {
            register: function (form) {
                var username = form.username.$modelValue;
                var email = form.email.$modelValue;
                var password = form.password.$modelValue;

                var url = API_URL + '/user/register.json?username=' + username + '&password=' + password + '&email=' + email;
                console.log(url);
                return $http.get(url);
            },
            editDetails: function (form) {
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
                var url = API_URL + '/user/editdetails.json?userdata=' + userData;
                console.log(url);
                return $http.get(url);
            },
            passwordforgot: function (form) {
                var email = form.email.$modelValue;
                var url = API_URL + '/user/passwordforgot.json?email=' + email;
                console.log(url);
                return $http.get(url);
            },
            signout: function () {
                var url = API_URL + '/user/logout.json';
                console.log(url);
                return $http.get(url);
            },
            login: function (username, password) {
                var url = API_URL + '/user/login.json?username=' + username + '&password=' + password;
                console.log(url);
                return $http.get(url);
            }
        };
    }]);
});