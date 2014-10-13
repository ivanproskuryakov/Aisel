'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * App Kernel
 */

define([
    'angular', 'angular-resource', 'angular-cookies', 'angular-sanitize', 'textAngular',
    'ui-bootstrap-tpls', 'ui-utils', 'angular-gravatar', 'md5', 'angular-disqus', 'angular-notify',
    'angular-route'],
    function (angular) {
        'use strict';

        var app = angular.module('app', [
            'ngCookies', 'ngResource', 'ngSanitize', 'ngRoute', 'ui.bootstrap',
            'ui.utils', 'ui.validate', 'ui.gravatar', 'textAngular', 'ngDisqus', 'cgNotify'])

        app.constant('API_URL', Aisel.settings.api)
            .constant("PRIMARY_LOCALE", Aisel.settings.locale.primary)
            .value('appSettings', [])
            .run(['$http', '$rootScope', 'rootService', 'initService',
                function ($http, $rootScope, rootService, initService) {
                    initService.launch();
                }])
            .config(function ($provide, $routeProvider, $locationProvider, $httpProvider) {
                $provide.factory('requestInterceptor', function ($q) {
                    return {
                        request: function (config) {
                            document.getElementById("page-is-loading").style.visibility = "visible";
                            return config || $q.when(config);
                        },
                        requestError: function (rejection) {
                            document.getElementById("page-is-loading").style.visibility = "hidden";
                            return $q.reject(rejection);
                        },
                        response: function (response) {
                            document.getElementById("page-is-loading").style.visibility = "hidden";
                            return response || $q.when(response);
                        },
                        responseError: function (rejection) {
                            document.getElementById("page-is-loading").style.visibility = "hidden";
                            return $q.reject(rejection);
                        }
                    };
                });
                $httpProvider.interceptors.push('requestInterceptor');
            });

        return app;
    })
;