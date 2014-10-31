'use strict';

/**
 * @ngdoc overview
 * @name Aisel
 *
 * @description
 * ...
 */

define(['app'], function (app) {
    app.service('contactService', ['$http', '$routeParams', 'API_URL',
        function ($http, $routeParams, API_URL) {
            return {
                send: function (form) {
                    var name = form.name.$modelValue;
                    var email = form.email.$modelValue;
                    var phone = form.phone.$modelValue;
                    var message = form.message.$modelValue;

                    var url = API_URL + '/contact/send.json?name=' + name + '&email=' + email + '&phone=' + phone + '&message=' + message;
                    console.log(url);
                    return $http.get(url);
                }
            };
        }]);
});