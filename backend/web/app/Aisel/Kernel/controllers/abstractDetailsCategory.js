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

                        setItemCategories(
                            $scope.item,
                            $scope.categories
                        );
                    }
                )
            });

            /**
             * Set categories
             *
             * @param {Object} item
             * @param {Object} categories
             */
            var setItemCategories = function (item, categories) {
                var isAnySelected = false;

                var setSelected = function (categories) {
                    angular.forEach(categories, function (category) {
                        angular.forEach(item.categories, function (c) {
                            if (c.id == category.id) {
                                category.selected = true;
                                isAnySelected = true;
                            }
                        });
                        if (category.children) {
                            setSelected(category.children)
                        }
                    });
                };

                if (categories.length) {
                    setSelected($scope.categories);

                    if (!isAnySelected) {
                        item.categories = [];
                    }
                }
            };

            /**
             * Update categories
             *
             * @param {Object} item
             * @param {Object} categories
             */
            $scope.updateItemCategories = function (item, categories) {
                item.categories = [];

                var findSelectedCategories = function (categories) {
                    angular.forEach(categories, function (category) {
                        if (category.selected) {
                            item.categories.push(category);
                        }
                        if (category.children) {
                            findSelectedCategories(category.children)
                        }
                    })
                };

                findSelectedCategories(categories);
            };

        });
});