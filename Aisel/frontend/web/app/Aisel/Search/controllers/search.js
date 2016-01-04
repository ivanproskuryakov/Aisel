'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselSearch
 * @description     ...
 */

define(['app'], function(app) {
    app.controller('SearchCtrl', ['$scope', '$stateParams', 'searchService',
        function($scope, $stateParams, searchService) {

            $scope.queryText = $stateParams.query;
            $scope.search = $stateParams.query;
            $scope.limit = 5;
            $scope.paginationPage = 1;
            $scope.collection = {};
            $scope.collection.total = 0;

            var handleSuccess = function(data, status) {
                console.log(data);
                $scope.collection = data;
            };
            searchService.getSearchResult($scope).success(handleSuccess);

            $scope.pageChanged = function(page) {
                $scope.paginationPage = page;
                searchService.getSearchResult($scope).success(handleSuccess);
            };
        }
    ]);
});
