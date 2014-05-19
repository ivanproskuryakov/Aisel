'use strict';

angular.module('aiselApp')
    .controller('UserPageCtrl', ['$location', '$log', '$modal', '$scope', '$routeParams', 'userService' , 'userPageService' , 'notify' ,
        function ($location, $log, $modal, $scope, $routeParams, userService, userPageService, notify) {

        $scope.loggedIn = false;

        var pageId = $routeParams.pageId;

        if (pageId) {
            var handleSuccess = function (data, status) {
                $scope.pageDetails = data;
//                console.log(data);
            };
            userPageService.getPageById(pageId).success(handleSuccess);



            // Save
            $scope.savePage = function () {
                notify('Page saved!');
            }


            // Save & Exit
            $scope.saveExitPage = function () {
                notify('Page saved!');
                $location.path('/user/page/list/');
            }


            // Close
            $scope.closePage = function () {
                var answer = confirm("Close Editor?")
                if (answer){
                    $location.path('/user/page/list/');
                }
                else{
                    //some code
                }
            }

            // Delete Page
            $scope.deletePage = function () {
                var modalInstance = $modal.open({
                    templateUrl: 'deletePageModal.html',
                    controller: ModalInstanceCtrl,
                    resolve: {
                        page: function () {
                            return $scope.pageDetails;
                        }
                    }

                });

                modalInstance.result.then(function (a) {
                    // Delete and redirect to page list
                    alert(a);
                }, function () {
                    $log.info('Modal dismissed at: ' + new Date());
                });
            };

        } else {
            $scope.pageLimit = 5;
            $scope.paginationPage = 1;
            $scope.categoryId = 0;
            $scope.userId = 31;
            var handleSuccess = function (data, status) {
                $scope.pageList = data;
            };

            // Pages
            userPageService.getPages($scope).success(
                function (data, status) {
                    $scope.pageList = data;
                }
            );

            $scope.pageChanged = function (page) {
                $scope.paginationPage = page;
                userPageService.getPages($scope).success(
                    function (data, status) {
                        $scope.pageList = data;
                    }
                );
            };
        }



    }]);

// ModalInstance for Delete event

var ModalInstanceCtrl = function ($scope, $modalInstance,page) {
    console.log(page);
    $scope.page = page;

    $scope.ok = function () {
        $modalInstance.close('close');
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
};