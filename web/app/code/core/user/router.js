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
        .when('/:locale/user/register/', {
            templateUrl: 'app/views/core/user/register.html',
            controller: 'UserCtrl',
            resolve: {
                factory: grantAccessGuest
            }
        })
        .when('/:locale/user/password/forgot/', {
            templateUrl: 'app/views/core/user/password-forgot.html',
            controller: 'UserCtrl',
            resolve: {
                factory: grantAccessGuest
            }
        })

        // Authenticated users actions
        .when('/:locale/user/information/', {
            templateUrl: 'app/views/core/user/information/dashboard.html',
            controller: 'UserCtrl',
            resolve: {
                factory: grantAccessAuthenticated
            }
        })
        .when('/:locale/user/information/edit/', {
            templateUrl: 'app/views/core/user/information/edit.html',
            controller: 'UserCtrl',
            resolve: {
                factory: grantAccessAuthenticated
            }
        })
        .when('/:locale/user/page/list/', {
            templateUrl: 'app/views/core/user/page/list.html',
            controller: 'UserPageListCtrl',
            resolve: {
                factory: grantAccessAuthenticated
            }
        })
        .when('/:locale/user/page/add/', {
            templateUrl: 'app/views/core/user/page/add.html',
            controller: 'UserPageAddCtrl',
            resolve: {
                factory: grantAccessAuthenticated
            }
        })
        .when('/:locale/user/page/edit/:pageId/', {
            templateUrl: 'app/views/core/user/page/edit.html',
            controller: 'UserPageEditCtrl',
            resolve: {
                factory: grantAccessAuthenticated
            }
        })
});
