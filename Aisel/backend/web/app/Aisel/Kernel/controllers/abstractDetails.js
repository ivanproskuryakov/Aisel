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
    app.controller('AbstractDetailsCtrl',
        function ($controller,
                  $scope,
                  $rootScope,
                  $stateParams,
                  itemService,
                  $state,
                  Env,
                  notify) {

            $scope.details = {
                id: $stateParams.id,
                name: $scope.route.name
            };
            $scope.item = {};
            var locale = Env.currentLocale();

            var errorNotify = function (data) {

                // If basic message
                //if (angular.isUndefined(data.error.message) === false) {
                //    notify('Response:' + data.error.code + ' Message:' + data.error.message);
                //}

                if (angular.isUndefined(data.message) === false) {
                    notify('Response:' + data.code + ' Message:' + data.message);
                }

                // If multiple errors
                if (angular.isUndefined(data.errors) === false) {
                    angular.forEach(data.errors, function (errorMessage, key) {
                        notify(
                            'Response: ' + data.code + ' ' +
                            '"' + key + '": ' + errorMessage
                        );
                    });
                }
            };

            /**
             * GET
             */
            if ($scope.details.id !== undefined) {
                itemService.get($scope.details.id).success(
                    function (data, status) {
                        $scope.item = data;
                    }
                ).error(function (data, status) {
                    if (data.error.code == 404) {
                        $state.transitionTo('home', {
                            locale: locale
                        });
                        notify('404 Noting found');
                        console.log(data);
                    } else {
                        errorNotify(data);
                    }
                });
            }

            /**
             * SAVE
             */
            $scope.editSave = function (callback) {
                // Existent item
                if ($scope.details.id !== undefined) {
                    itemService.save($scope.item).success(
                        function (data, status) {
                            notify($scope.route.name + ' has been saved');
                            console.log(data);
                        }
                    ).error(function (data, status) {
                        errorNotify(data);
                    });
                }
                // New item
                if ($scope.details.id === undefined) {
                    itemService.create($scope.item).success(
                        function (data, status) {
                            notify($scope.route.name + ' was added');
                            $state.transitionTo(
                                $scope.route.edit, {
                                    locale: Env.currentLocale(),
                                    id: data.id
                                }
                            );
                        }
                    ).error(function (data, status) {
                        errorNotify(data);
                    });
                }

                if (callback) callback();
            };

            /**
             * SAVE & EXIT
             */
            $scope.editSaveAndExit = function () {
                itemService.save($scope.item).success(
                    function (data, status) {
                        notify($scope.route.name + ' has been saved');
                        $state.transitionTo(
                            $scope.route.collection, {
                                locale: Env.currentLocale()
                            }
                        );
                    }
                ).error(function (data, status) {
                    errorNotify(data);
                });
            };

            /**
             * CANCEL
             */
            $scope.editCancel = function () {
                $state.transitionTo(
                    $scope.route.collection, {
                        locale: Env.currentLocale()
                    }
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
                            $scope.route.collection, {
                                locale: Env.currentLocale()
                            }
                        );
                    }
                ).error(function (data, status) {
                    errorNotify(data);
                });
            };

        });
});
