'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselResource
 * @description     AbstractDetailsCtrl
 */

define(['app'], function (app) {
    app.controller('AbstractDetailsCtrl', function ($controller, $scope, $stateParams, itemService, $state, Environment, notify) {

        $scope.details = {
            id: $stateParams.id,
            name: $scope.route.name
        };
        $scope.item = {};

        /**
         * GET
         */
        if ($scope.details.id !== undefined) {
            itemService.get($scope.details.id).success(
                function (data, status) {
                    $scope.item = data;
                }
            );
        };

        /**
         * SAVE
         */
        $scope.editSave = function () {
            // Existent item
            if ($scope.details.id !== undefined) {
                itemService.save($scope.item).success(
                    function (data, status) {
                        notify($scope.route.name + ' has been saved');
                        console.log(data);
                    }
                );
            }
            // New item
            if ($scope.details.id === undefined) {
                itemService.create($scope.item).success(
                    function (data, status) {
                        notify($scope.route.name + ' was added');
                        $state.transitionTo(
                            $scope.route.edit,
                            {locale: Environment.currentLocale(), id: data.id}
                        );
                    }
                );
            }
        };

        /**
         * SAVE & EXIT
         */
        $scope.editSaveAndExit = function () {
            itemService.save($scope.item).success(
                function (data, status) {
                    notify($scope.route.name + ' has been saved');
                    $state.transitionTo(
                        $scope.route.collection,
                        {locale: Environment.currentLocale()}
                    );
                }
            );
        };

        /**
         * CANCEL
         */
        $scope.editCancel = function () {
            $state.transitionTo(
                $scope.route.collection,
                {locale: Environment.currentLocale()}
            );
        };

        /**
         * DELETE
         */
        $scope.editDelete = function () {
            itemService.remove($scope.details.id).success(
                function (data, status) {
                    notify($scope.route.name + ' has been deleted');
                    $state.transitionTo(
                        $scope.route.collection,
                        {locale: Environment.currentLocale()}
                    );
                }
            );
        };

    });
});