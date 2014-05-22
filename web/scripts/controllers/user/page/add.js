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
                var answer = confirm("You haven't finished your post yet. Do you want to leave without finishing? " +
                    "\n\n Are you sure you want to leave this page?");
                if (answer){
                    $location.path('/user/page/list/');
                }
                else{
                    //some code
                }
            }


        }]);
