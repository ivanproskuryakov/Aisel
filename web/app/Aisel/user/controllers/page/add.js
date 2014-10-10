'use strict';

/**
 * @ngdoc overview
 *
 * @name aiselApp
 *
 * @description
 *
 * ...
 */

define(['app'], function (app) {
    app.controller('UserPageAddCtrl', ['$location', '$log', '$modal', '$scope', '$routeParams', 'userService', 'userPageService', 'userCategoryService', 'notify',
        function ($location, $log, $modal, $scope, $routeParams, userService, userPageService, userCategoryService, notify) {

            $scope.pageDetails = {};
            $scope.pageDetails.page = {};
            $scope.pageDetails.page.title = '';
            $scope.pageDetails.page.content = '';
            $scope.pageDetails.page.status = false;

            userCategoryService.appCategories().success(
                function (data, status) {
                    $scope.websiteCategories = data;
                }
            );

            $scope.addPage = function () {
                console.log($scope.pageDetails);
                userPageService.addPage($scope.pageDetails, $scope.websiteCategories).success(
                    function (data, status) {
                        console.log(data);
                        notify(data.message);
                        if (data.status == 'success') {
                            $location.path('/user/page/edit/' + data.pageid + '/');
                        }
                    }
                );
            };

            // Save & Exit
            $scope.saveExitPage = function () {
                notify('Post saved!');
                $location.path('/user/page/list/');
            }

            // Close
            $scope.closePage = function () {
                var answer = confirm("You haven't finished your post yet. Do you want to leave without finishing? " +
                    "\n\n Are you sure you want to leave this page?");
                if (answer) {
                    $location.path('/user/page/list/');
                }
                else {
                    //some code
                }
            }


        }]);
});