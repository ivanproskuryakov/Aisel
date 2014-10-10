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
            'ui.utils', 'ui.validate', 'ui.gravatar', 'textAngular', 'ngDisqus', 'cgNotify']);

        app.constant('API_URL', Aisel.settings.api)
            .constant("PRIMARY_LOCALE", Aisel.settings.locale.primary);

        app.value('appSettings', []);
        app.run(['$http', '$rootScope', 'rootService',
            function ($http, $rootScope, rootService) {
                rootService.init();
            }]);
//    app.config(function ($provide, $routeProvider, $locationProvider, $httpProvider) {
//        $provide.factory('requestInterceptor', function ($q) {
//            return {
//                request: function (config) {
//                    $('.loading-interceptor').show();
//                    return config || $q.when(config);
//                },
//                requestError: function (rejection) {
//                    $('.loading-interceptor').hide();
//                    return $q.reject(rejection);
//                },
//                response: function (response) {
//                    $('.loading-interceptor').hide();
//                    return response || $q.when(response);
//                },
//                responseError: function (rejection) {
//                    $('.loading-interceptor').hide();
//                    return $q.reject(rejection);
//                }
//            };
//        });
//        $httpProvider.interceptors.push('requestInterceptor');
//    });

        return app;
    })
;