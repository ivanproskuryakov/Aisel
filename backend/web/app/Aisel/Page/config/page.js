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
    app.config(['$stateProvider', function ($stateProvider) {
        $stateProvider
            .state("pages", {
                url: "/:locale/pages/",
                templateUrl: '/app/Kernel/Resource/views/collection.html',
                controller: 'PageCtrl'
            })
            .state("pageView", {
                url: "/:locale/page/view/:id/",
                templateUrl: '/app/Aisel/Page/views/page-detail.html',
                controller: 'PageDetailCtrl'
            })
    }]);
});