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
 * @description     ...
 */

define(['app'], function (app) {
    app.controller('PageDetailCtrl', function ($scope, $stateParams, pageService, $rootScope) {
        var pageURL = $stateParams.pageId;
        var handleSuccess = function (data, status) {
            $scope.pageDetails = data;
            $rootScope.pageTitle = $scope.pageDetails.page.title;

            // Disqus comments
            window.disqus_shortname = $rootScope.disqusShortname;
            $scope.showComments = $rootScope.disqusStatus && $scope.pageDetails.page.comment_status;
        };
        pageService.getPageByURL(pageURL).success(handleSuccess);
    });
});