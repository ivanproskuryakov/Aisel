'use strict';

angular.module('projectxApp', [
  'ngCookies',
  'ngResource',
  'ngSanitize',
  'ngRoute'
])
  .config(function ($routeProvider) {
    $routeProvider
        .when('/', {
        templateUrl: 'views/main.html',
        controller: 'MainCtrl'
        })
        .when('/page/', {
            templateUrl: 'views/page.html',
            controller: 'PageCtrl'
        })
        .when('/about/', {
            templateUrl: 'views/about.html',
            controller: 'AboutCtrl'
        })
        .when('/contact/', {
            templateUrl: 'views/contact.html',
            controller: 'ContactCtrl'
        })
        .otherwise({
        redirectTo: '/'
        });
  });
