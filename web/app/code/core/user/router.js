'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 * # aiselApp
 *
 * User router
 */

aiselApp.config(function ($provide, $routeProvider, $locationProvider, $httpProvider) {

    $routeProvider

        // Actions only for guest users
        .when('/user/register/', {
            templateUrl: 'app/views/core/user/register.html',
            controller: 'UserCtrl',
            resolve: {
                factory: grantAccessGuest
            }
        })
        .when('/user/password/forgot/', {
            templateUrl: 'app/views/core/user/password-forgot.html',
            controller: 'UserCtrl',
            resolve: {
                factory: grantAccessGuest
            }
        })

        // Authenticated users actions
        .when('/user/information/', {
            templateUrl: 'app/views/core/user/information/dashboard.html',
            controller: 'UserCtrl',
            resolve: {
                factory: grantAccessAuthenticated
            }
        })
        .when('/user/information/edit/', {
            templateUrl: 'app/views/core/user/information/edit.html',
            controller: 'UserCtrl',
            resolve: {
                factory: grantAccessAuthenticated
            }
        })
        .when('/user/page/list/', {
            templateUrl: 'app/views/core/user/page/list.html',
            controller: 'UserPageListCtrl',
            resolve: {
                factory: grantAccessAuthenticated
            }
        })
        .when('/user/page/add/', {
            templateUrl: 'app/views/core/user/page/add.html',
            controller: 'UserPageAddCtrl',
            resolve: {
                factory: grantAccessAuthenticated
            }
        })
        .when('/user/page/edit/:pageId/', {
            templateUrl: 'app/views/core/user/page/edit.html',
            controller: 'UserPageEditCtrl',
            resolve: {
                factory: grantAccessAuthenticated
            }
        })
});
