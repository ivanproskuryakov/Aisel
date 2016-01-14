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
    app.controller('PageDetailCtrl', function ($scope, $stateParams, resourceService, $rootScope) {
        var pageURL = $stateParams.pageId;
        var pageService = new resourceService('page');

        var handleSuccess = function (data, status) {
            $scope.page = data;
            $rootScope.pageTitle = data.name;

            window.disqus_shortname = $rootScope.disqusShortname;
            $scope.showComments = $rootScope.disqusStatus;
        };

        pageService.getItemByURL(pageURL).success(handleSuccess);
    });
});
