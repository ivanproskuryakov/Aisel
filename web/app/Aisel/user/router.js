'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * User router
 */

aiselApp.config(function ($provide, $routeProvider, $locationProvider, $httpProvider) {

    $routeProvider

        // Actions only for guest users
        .when('/:locale/user/register/', {
            templateUrl: 'app/Aisel/user/views/register.html',
            controller: 'UserCtrl',
            resolve: {
                factory: grantAccessGuest
            }
        })
        .when('/:locale/user/password/forgot/', {
            templateUrl: 'app/Aisel/user/views/password-forgot.html',
            controller: 'UserCtrl',
            resolve: {
                factory: grantAccessGuest
            }
        })

        // Authenticated users actions
        .when('/:locale/user/information/', {
            templateUrl: 'app/Aisel/user/views/information/dashboard.html',
            controller: 'UserCtrl',
            resolve: {
                factory: grantAccessAuthenticated
            }
        })
        .when('/:locale/user/information/edit/', {
            templateUrl: 'app/Aisel/user/views/information/edit.html',
            controller: 'UserCtrl',
            resolve: {
                factory: grantAccessAuthenticated
            }
        })
        .when('/:locale/user/page/list/', {
            templateUrl: 'app/Aisel/user/views/page/list.html',
            controller: 'UserPageListCtrl',
            resolve: {
                factory: grantAccessAuthenticated
            }
        })
        .when('/:locale/user/page/add/', {
            templateUrl: 'app/Aisel/user/views/page/add.html',
            controller: 'UserPageAddCtrl',
            resolve: {
                factory: grantAccessAuthenticated
            }
        })
        .when('/:locale/user/page/edit/:pageId/', {
            templateUrl: 'app/Aisel/user/views/page/edit.html',
            controller: 'UserPageEditCtrl',
            resolve: {
                factory: grantAccessAuthenticated
            }
        })
});
