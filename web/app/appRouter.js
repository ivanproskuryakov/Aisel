'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * Main router provider in separate file, for better extensibility
 * Each module has its own router file.
 * Please define only global routes in this appRouter.js file
 */

aiselApp.config(function ($provide, $routeProvider, LOCALE) {
    $routeProvider

    /**
     * Default route. Redirect to homepage if nothing was found
     */
        .otherwise({
            redirectTo: '/'+LOCALE.primary+'/'
        });
});

/**
 * Simple helper functions for user ACL
 * see more at user/router.js
 */
var grantAccessAuthenticated = function ($rootScope, $location, notify) {
    if (!$rootScope.isAuthenticated) {
        $location.path("/");
    }
};
var grantAccessGuest = function ($rootScope, $location, notify) {
    if ($rootScope.isAuthenticated) {
        $location.path("/");
    }
};