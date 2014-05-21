'use strict';

angular.module('aiselApp')
    .controller('UserPageAddCtrl', ['$location', '$log', '$modal', '$scope', '$routeParams', 'userService' , 'userPageService' , 'notify' ,
        function ($location, $log, $modal, $scope, $routeParams, userService, userPageService, notify) {



            $scope.addPage = function() {
                console.log($scope.pageDetails);
                userPageService.addPage($scope.pageDetails).success(
                    function(data, status) {
                        notify(data.message);
                    }
                );
            };

            // Save & Exit
            $scope.saveExitPage = function () {
                notify('Page saved!');
                $location.path('/user/page/list/');
            }

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


        }]);
