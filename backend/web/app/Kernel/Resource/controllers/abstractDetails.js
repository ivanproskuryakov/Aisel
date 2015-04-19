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
    app.controller('AbstractDetailsCtrl', function ($controller, $scope, $stateParams, pageService, $state, Environment, notify) {

        $scope.details = {
            id: $stateParams.id,
            name: $scope.route.name,
            item: {}
        };

        // GET
        if ($scope.details.id !== undefined) {
            pageService.get($scope.details.id).success(
                function (data, status) {
                    $scope.details.item = data.item;
                    $scope.details.item.categories = data.item.categories;
                }
            );
        };

        // SAVE
        $scope.editSave = function () {
            // Existent page
            if ($scope.details.id !== undefined) {
                pageService.save($scope.details.item).success(
                    function (data, status) {
                        notify($scope.route.name + ' has been saved');
                        console.log(data);
                    }
                );
            }
            // New page
            if ($scope.details.id === undefined) {
                pageService.create($scope.details.item).success(
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

        // SAVE & EXIT
        $scope.editSaveAndExit = function () {
            pageService.save($scope.details.item).success(
                function (data, status) {
                    notify($scope.route.name + ' has been saved');
                    $state.transitionTo(
                        $scope.route.collection,
                        {locale: Environment.currentLocale()}
                    );
                }
            );
        };

        // CANCEL
        $scope.editCancel = function () {
            $state.transitionTo(
                $scope.route.collection,
                {locale: Environment.currentLocale()}
            );
        };

        // DELETE
        $scope.editDelete = function () {
            pageService.remove($scope.details.id).success(
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