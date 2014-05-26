'use strict';

angular.module('aiselApp')
    .controller('UserPageEditCtrl', ['$location', '$log', '$modal', '$scope', '$routeParams', 'userService' , 'userPageService' , 'userCategoryService' , 'notify' ,
        function ($location, $log, $modal, $scope, $routeParams, userService, userPageService, userCategoryService, notify) {

            $scope.loggedIn = false;

            var pageId = $routeParams.pageId;

            userPageService.getPageById(pageId).success(
                function (data, status) {
                    $scope.pageDetails = data;
                    $scope.pageEditTitle = data.page.title;
                }
            );
            userCategoryService.appCategories().success(
                function (data, status) {
                    $scope.websiteCategories = data;
                }
            );
            $scope.isCategorySelected = function (category) {
                if ($scope.pageDetails.categories[category.id]) {
                    category.selected = true;
                    return true;
                }
                return false;
            }

            $scope.cbCategory = function (category) {
                console.log(cbCategory);
            }


            // Actions::
            // Save
            $scope.savePage = function () {
                console.log($scope.websiteCategories);
//                userPageService.savePage($scope.pageDetails, $scope.websiteCategories).success(
//                    function (data, status) {
//                        console.log(data.message);
//                        notify(data.message);
//                        $scope.pageEditTitle = $scope.pageDetails.page.title;
//                    }
//                );
            };

            // Save & Exit
            $scope.saveExitPage = function () {
                console.log($scope.pageDetails);
                userPageService.savePage($scope.pageDetails).success(
                    function (data, status) {
                        notify(data.message);
                        $location.path('/user/page/list/');
                    }
                );
            };

            // Delete Page
            $scope.deletePage = function () {
                var modalInstance = $modal.open({
                    templateUrl: 'deletePageModal.html',
                    controller: PageInstanceCtrl,
                    resolve: {
                        p: function () {
                            return $scope.pageDetails;
                        }
                    }

                });

                modalInstance.result.then(function (a) {
                    userPageService.deletePage($scope.pageDetails).success(
                        function (data, status) {
                            notify(data.message);
                            if (data.status == 'success') {
                                $location.path('/user/page/list/');
                            }
                        }
                    );
                }, function () {
                    $log.info('Modal dismissed at: ' + new Date());
                });
            };

            // Close Page
            $scope.closePage = function () {
                var answer = confirm("You haven't finished your post yet. Do you want to leave without finishing? " +
                    "\n\n Are you sure you want to leave this page?");
                if (answer) {
                    $location.path('/user/page/list/');
                }
            }


        }]);

// ModalInstance for Delete event

var PageInstanceCtrl = function ($scope, $modalInstance, p) {

    $scope.pageDetails = p;
//    console.log(page);

    $scope.ok = function () {
        $modalInstance.close('close');
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
};