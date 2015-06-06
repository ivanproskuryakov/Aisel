'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselKernel
 * @description     AbstractDetailsCtrl
 */

define(['app'], function (app) {
    app.controller('AbstractDetailsCategoryCtrl',
        function ($controller, $scope, itemService) {

            angular.extend(this, $controller('AbstractDetailsCtrl', {
                $scope: $scope,
                itemService: itemService
            }));

            $scope.$watch("item.locale", function () {
                itemService.getCategoryTree($scope.item.locale).success(
                    function (data, status) {
                        $scope.categories = data;
                        $scope.setItemCategories();
                    }
                )
            });

            /**
             * Set categories
             */
            $scope.setItemCategories = function () {
                var isAnySelected = false;

                var setSelected = function (categories) {
                    angular.forEach(categories, function (category) {
                        angular.forEach($scope.item.categories, function (c) {
                            if (c.id == category.id){
                                category.selected = true;
                                //isAnySelected = true;
                            }
                        });
                        if (category.children) {
                            setSelected(category.children)
                        }
                    });
                };

                if ($scope.categories.length) {
                    setSelected($scope.categories);

                    if (!isAnySelected) {
                        $scope.item.categories = [];
                    }
                }
            };

            /**
             * Update categories
             */
            $scope.updateItemCategories = function () {
                $scope.item.categories = [];

                var findSelectedCategories = function (categories) {
                    angular.forEach(categories, function (category) {
                        if (category.selected) {
                            $scope.item.categories.push(category);
                        }
                        if (category.children) {
                            findSelectedCategories(category.children)
                        }
                    })
                };

                findSelectedCategories($scope.categories);
            };

        });
});