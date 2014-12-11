'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @ngdoc           overview
 * @name            Aisel
 * @description     ...
 */

define(['app', './controllers/search', './services/search', './directives/main'], function (app) {
    console.log('Search module loaded ...');
    app.config(function ($provide, $routeProvider, $locationProvider, $httpProvider) {
        $routeProvider
            // Search
            .when('/:locale/search/:query', {
                templateUrl: '/app/Aisel/Search/views/search.html',
                controller: 'SearchCtrl'
            })
    });
});