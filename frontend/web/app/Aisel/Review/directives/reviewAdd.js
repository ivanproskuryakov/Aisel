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
    app.directive('aiselReviewAdd', ['$rootScope', '$compile', 'Environment', 'resourceService', 'authService', 'notify',
        function ($rootScope, $compile, Environment, resourceService, authService, notify) {
            return {
                restrict: 'EA',
                scope: {
                    resourceName: '=',
                    resource: '='
                },
                link: function ($scope, element, attrs) {
                    $scope.isDisabled = false;

                    var locale = Environment.currentLocale();
                    var resource = new resourceService($scope.resourceName);

                    $scope.addReview = function () {

                        // if user is a guest - redirect or login page
                        if (typeof $rootScope.user === 'undefined') {
                            authService.authenticateWithModal();
                        } else {
                            $scope.isDisabled = true;

                            var params = {
                                subject: {
                                    id: $scope.resource.id
                                },
                                locale: locale,
                                name: $scope.name,
                                content: $scope.content
                            };

                            resource.addReview(params).success(
                                function (data, status) {
                                    notify('Review was added');

                                    $scope.resource.reviews.splice(0, 0, params);
                                    $scope.isDisabled = false;
                                    $scope.name = '';
                                    $scope.content = '';
                                }
                            ).error(function (data, status) {
                                console.log(data);
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
