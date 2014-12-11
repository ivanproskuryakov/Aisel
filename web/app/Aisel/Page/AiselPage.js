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
 * @description     Product router
 */

define(['app',
    './controllers/page', './controllers/pageDetails',
    './services/page',
    './controllers/pageCategory', './controllers/pageCategoryDetails',
    './services/pageCategory',
], function (app) {
    console.log('Page module loaded ...');
    app.config(function ($provide, $routeProvider, $locationProvider, $httpProvider) {
        $routeProvider

            // Pages
            .when('/:locale/pages/', {
                templateUrl: '/app/Aisel/Page/views/page.html',
                controller: 'PageCtrl'
            })
            .when('/:locale/page/view/:pageId/', {
                templateUrl: '/app/Aisel/Page/views/page-detail.html',
                controller: 'PageDetailCtrl'
            })
            // Categories
            .when('/:locale/page/categories/', {
                templateUrl: '/app/Aisel/Page/views/category.html',
                controller: 'PageCategoryCtrl'
            })
            .when('/:locale/page/category/:categoryId/', {
                templateUrl: '/app/Aisel/Page/views/category-detail.html',
                controller: 'PageCategoryDetailCtrl'
            })

    });
});