'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselReview
 * @description     ...
 */

define(['app'], function (app) {
    app.directive('aiselReviewAdd',
        [
            '$rootScope',
            '$compile',
            'Env',
            'resourceService',
            'authService',
            'notify',
            '$http',
            function ($rootScope,
                      $compile,
                      Env,
                      resourceService,
                      authService,
                      notify,
                      $http) {
                return {
                    restrict: 'EA',
                    scope: {
                        resourceName: '=',
                        resource: '='
                    },
                    link: function ($scope, element, attrs) {
                        $scope.isDisabled = false;

                        var locale = Env.currentLocale();
                        var resource = new resourceService($scope.resourceName);

                        $scope.addReview = function () {

                            // if user is a guest - redirect or login page
                            if (typeof $rootScope.user === 'undefined') {
                                authService.authenticateWithModal();
                            } else {
                                $scope.isDisabled = true;

                                console.log($scope.resource);

                                var params = {
                                    subject: {
                                        id: $scope.resource.id
                                    },
                                    locale: locale,
                                    name: $scope.name,
                                    content: $scope.content
                                };

                                /**
                                 * addReview
                                 * @param {Array} params
                                 */
                                resource.addReview(params).success(
                                    function (data, status, headers, config) {
                                        var reviewURL = headers().location;

                                        $http.get(reviewURL).success(
                                            function (data, status) {
                                                notify('Review was added, thank you!');

                                                $scope.resource.reviews.splice(0, 0, data);
                                                $scope.isDisabled = false;
                                                $scope.name = '';
                                                $scope.content = '';
                                            }
                                        ).error(
                                            function (data, status) {
                                                notify(data.message);
                                                $scope.isDisabled = false;
                                            }
                                        );
                                    }
                                ).error(function (data, status) {
                                    notify(data.message);
                                    $scope.isDisabled = false;
                                });

                            }
                        };
                    },
                    templateUrl: '/app/Aisel/Review/views/directives/review-add.html'
                };
            }
        ]);
});
