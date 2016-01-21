'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselPage
 * @description     Module configuration
 */

define(['app'], function (app) {
    app
        .config(['$stateProvider', function ($stateProvider) {
            $stateProvider
                .state("pages", {
                    url: "/:locale/page/",
                    templateUrl: '/app/Aisel/Kernel/views/collection.html',
                    controller: 'PageCtrl'
                })
                .state("pageEdit", {
                    url: "/:locale/page/edit/:id/",
                    templateUrl: '/app/Aisel/Page/views/edit.html',
                    controller: 'PageDetailsCtrl'
                })
                .state("pageNew", {
                    url: "/:locale/page/new/",
                    templateUrl: '/app/Aisel/Page/views/edit.html',
                    controller: 'PageDetailsCtrl'
                })

                .state("pageReviews", {
                    url: "/:locale/page/review/",
                    templateUrl: '/app/Aisel/Kernel/views/collection.html',
                    controller: 'PageReviewCtrl'
                })
                .state("pageReviewEdit", {
                    url: "/:locale/page/review/edit/:id/",
                    templateUrl: '/app/Aisel/Page/views/edit-review.html',
                    controller: 'PageReviewDetailsCtrl'
                })
                .state("pageReviewNew", {
                    url: "/:locale/page/review/new/",
                    templateUrl: '/app/Aisel/Page/views/edit-review.html',
                    controller: 'PageReviewDetailsCtrl'
                })

                .state("pageNode", {
                    url: "/:locale/page/node/",
                    templateUrl: '/app/Aisel/Kernel/views/collection.html',
                    controller: 'PageNodeCtrl'
                })
                .state("pageNodeEdit", {
                    url: "/:locale/page/node/edit/:id/",
                    templateUrl: '/app/Aisel/Page/views/edit-node.html',
                    controller: 'PageNodeDetailsCtrl'
                })
                .state("pageNodeNew", {
                    url: "/:locale/page/node/new/",
                    templateUrl: '/app/Aisel/Page/views/edit-node.html',
                    controller: 'PageNodeDetailsCtrl'
                })
        }])

        .run(['$rootScope', 'Env', function ($rootScope, Env) {

            $rootScope.adminMenu.push({
                "ordering": 100,
                "title": 'Pages',
                "children": {
                    "pages": {
                        "ordering": 100,
                        "slug": '/page/',
                        "title": 'Pages'
                    },
                    "pageNode": {
                        "ordering": 200,
                        "slug": '/page/node/',
                        "title": 'Nodes'
                    },
                    "pageReview": {
                        "ordering": 300,
                        "slug": '/page/review/',
                        "title": 'Reviews'
                    }
                }
            });

            $rootScope.sellerMenu.push({
                "ordering": 100,
                "title": 'Pages',
                "children": {
                    "pages": {
                        "ordering": 100,
                        "slug": '/page/',
                        "title": 'Pages'
                    },
                    "pageReview": {
                        "ordering": 300,
                        "slug": '/page/review/',
                        "title": 'Reviews'
                    }
                }
            });
        }]);
});
