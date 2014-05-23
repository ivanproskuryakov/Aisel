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


                $scope.savePage = function () {
                    console.log($scope.pageDetails);
                    userPageService.savePage($scope.pageDetails).success(
                        function (data, status) {
//                        console.log(data.message);
                            notify(data.message);
                            $scope.pageEditTitle = $scope.pageDetails.page.title;
                        }
                    );
                };


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