'use strict';

angular.module('aiselApp')
    .controller('UserPageEditCtrl', ['$location', '$log', '$modal', '$scope', '$routeParams', 'userService' , 'userPageService' , 'notify' ,
        function ($location, $log, $modal, $scope, $routeParams, userService, userPageService, notify) {

        $scope.loggedIn = false;

        var pageId = $routeParams.pageId;

        if (pageId) {
            var handleSuccess = function (data, status) {
                $scope.pageDetails = data;
                $scope.pageEditTitle = data.page.title;
//                console.log(data);
            };
            userPageService.getPageById(pageId).success(handleSuccess);


            $scope.savePage = function() {
                console.log($scope.pageDetails);
                console.log($scope.pageDetails.page.id);
                userPageService.savePage($scope.pageDetails).success(
                    function(data, status) {
                        notify(data.message);
                    }
                );
            };


            // Close
            $scope.closePage = function () {
                var answer = confirm("Changes would not be saved! Close?")
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
                    controller: PageInstanceCtrl,
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

        }

    }]);

// ModalInstance for Delete event

var PageInstanceCtrl = function ($scope, $modalInstance,page) {
    console.log(page);
    $scope.page = page;

    $scope.ok = function () {
        $modalInstance.close('close');
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
};