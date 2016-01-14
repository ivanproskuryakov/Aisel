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
                    url: "/:locale/page/node/:lang/",
                    templateUrl: '/app/Aisel/Kernel/views/node.html',
                    controller: 'PageNodeCtrl'
                })
                .state("pageNodeEdit", {
                    url: "/:locale/page/node/edit/:lang/:id/",
                    templateUrl: '/app/Aisel/Page/views/edit-node.html',
                    controller: 'PageNodeDetailsCtrl'
                })
        }])

        .run(['$rootScope', 'Env', function ($rootScope, Env) {
            $rootScope.topMenu.push({
                "ordering": 100,
                "title": 'Pages',
                "roles": ['ROLE_ADMIN', 'ROLE_USER'],
                "children": {
                    "pages": {
                        "ordering": 100,
                        "slug": '/page/',
                        "roles": ['ROLE_ADMIN', 'ROLE_USER'],
                        "title": 'Pages'
                    },
                    "pageNode": {
                        "ordering": 200,
                        "roles": ['ROLE_ADMIN'],
                        "slug": '/page/node/' + Env.currentLocale() + '/',
                        "title": 'Nodes'
                    },
                    "pageReview": {
                        "ordering": 300,
                        "roles": ['ROLE_ADMIN', 'ROLE_USER'],
                        "slug": '/page/review/',
                        "title": 'Reviews'
                    }
                }
            });
        }]);
});
