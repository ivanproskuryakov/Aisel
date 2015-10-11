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
        ['$location', '$scope', '$stateParams', 'productService', 'productCategoryService', 'Environment', '$controller',
            function ($location, $scope, $stateParams, productService, productCategoryService, Environment, $controller) {
                $scope.media = Environment.settings.media;
                $scope.pageLimit = 5;
                $scope.paginationPage = 1;
                $scope.categoryId = $stateParams.categoryId;

                // Category Information
                productCategoryService.getItem($scope.categoryId).success(
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
