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

define(['app'], function(app) {
    app.controller('AbstractDetailsNodeCtrl',
        function($controller, $scope, itemService) {

            angular.extend(this, $controller('AbstractDetailsCtrl', {
                $scope: $scope,
                itemService: itemService
            }));

            $scope.$watch("item.locale", function() {

                if (angular.isUndefined($scope.item.locale) === false) {

                    itemService.getNodeTree($scope.item.locale).success(
                        function(data, status) {
                            $scope.nodes = data;

                            setItemNodes(
                                $scope.item,
                                $scope.nodes
                            );
                        }
                    )
                }

            });

            /**
             * Set nodes
             *
             * @param {Object} item
             * @param {Object} nodes
             */
            var setItemNodes = function(item, nodes) {

                var isAnySelected = false;
                var setSelected = function(nodes) {
                    angular.forEach(nodes, function(node) {
                        angular.forEach(item.nodes, function(c) {

                            if (c.id == node.id) {

                                node.selected = true;
                                isAnySelected = true;
                            }
                        });

                        if (node.children) {
                            setSelected(node.children)
                        }
                    });
                };

                //console.log(nodes);
                //console.log(item.nodes);

                if (nodes) {
                    setSelected($scope.nodes);

                    if (!isAnySelected) {
                        item.nodes = [];
                    }
                }
            };

            /**
             * Update nodes
             *
             * @param {Object} item
             * @param {Object} nodes
             */
            $scope.updateItemNodes = function(item, nodes) {
                item.nodes = [];

                var findSelectedNodes = function(nodes) {
                    angular.forEach(nodes, function(node) {
                        if (node.selected) {
                            item.nodes.push(node);
                        }
                        if (node.children) {
                            findSelectedNodes(node.children)
                        }
                    })
                };

                findSelectedNodes(nodes);
            };

        });
});
