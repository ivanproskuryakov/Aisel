'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselProduct
 * @description     ...
 */

define(['app'], function (app) {
    app.controller('ProductCategoryDetailCtrl',
        ['$location', '$scope', '$stateParams', 'resourceService', 'Env', '$controller',
            function ($location, $scope, $stateParams, resourceService, Env, $controller) {
                $scope.media = Env.media;
                $scope.pageLimit = 5;
                $scope.paginationPage = 1;
                $scope.categoryId = $stateParams.categoryId;

                var productCategoryService = new resourceService('product/node');
                var productService = new resourceService('product');

                // Category Information
                productCategoryService.getItemByURL($scope.categoryId).success(
                    function (data, status) {
                        $scope.category = data;
                    }
                );

                angular.extend(this, $controller('AbstractCollectionCtrl', {
                    $scope: $scope,
                    itemService: productService
                }));
            }
        ]);
});
