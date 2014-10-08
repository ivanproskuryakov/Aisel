'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * Application core module
 */

define(['angularAMD',
    'angular-resource',
    'angular-cookies',
    'angular-sanitize',
    'textAngular',
    'ui-bootstrap-tpls',
    'ui-utils',
    'angular-gravatar',
    'md5',
    'angular-disqus',
    'angular-notify',
    'angular-route'
], function (angularAMD) {
    var app = angular.module('app', [
            'ngCookies',
            'ngResource',
            'ngSanitize',
            'ngRoute',
            'ui.bootstrap',
            'ui.utils',
            'ui.validate',
            'ui.gravatar',
            'textAngular',
            'ngDisqus',
            'cgNotify'
        ])
        .value('appSettings', [])
        .run(['$http', '$rootScope', 'rootService', '$route', '$routeParams',
            function ($http, $rootScope, rootService, $route, $routeParams, $location) {
                rootService.init();
            }])
        .config(function ($provide, $routeProvider, $locationProvider, $httpProvider) {

            /**
             * HTTP calls Interception
             */
            $provide.factory('requestInterceptor', function ($q) {
                return {
                    request: function (config) {
                        $('.loading-interceptor').show();
                        return config || $q.when(config);
                    },
                    requestError: function (rejection) {
                        $('.loading-interceptor').hide();
                        return $q.reject(rejection);
                    },
                    response: function (response) {
                        $('.loading-interceptor').hide();
                        return response || $q.when(response);
                    },
                    responseError: function (rejection) {
                        $('.loading-interceptor').hide();
                        return $q.reject(rejection);
                    }
                };
            });
            $httpProvider.interceptors.push('requestInterceptor');
        });
    return angularAMD.bootstrap(app);
});


//
//    var aiselApp = angular.module('aiselApp', [
//            'ngCookies',
//            'ngResource',
//            'ngSanitize',
//            'ngRoute',
//            'ui.bootstrap',
//            'ui.utils',
//            'ui.validate',
//            'ui.gravatar',
//            'textAngular',
//            'ngDisqus',
//            'cgNotify'
//        ]);
//
//        .value('appSettings', [])
//        .run(['$http', '$rootScope', 'rootService', '$route', '$routeParams',
//            function ($http, $rootScope, rootService, $route, $routeParams, $location) {
//                rootService.init();
//            }])
//        .config(function ($provide, $routeProvider, $locationProvider, $httpProvider) {
//
//            /**
//             * HTTP calls Interception
//             */
//            $provide.factory('requestInterceptor', function ($q) {
//                return {
//                    request: function (config) {
//                        $('.loading-interceptor').show();
//                        return config || $q.when(config);
//                    },
//                    requestError: function (rejection) {
//                        $('.loading-interceptor').hide();
//                        return $q.reject(rejection);
//                    },
//                    response: function (response) {
//                        $('.loading-interceptor').hide();
//                        return response || $q.when(response);
//                    },
//                    responseError: function (rejection) {
//                        $('.loading-interceptor').hide();
//                        return $q.reject(rejection);
//                    }
//                };
//            });
//            $httpProvider.interceptors.push('requestInterceptor');
//        });
//
//    return aiselApp;
//}