'use strict';

angular.module('aiselApp')
    .controller('UserPageAddCtrl', ['$location', '$log', '$modal', '$scope', '$routeParams', 'userService' , 'userPageService' , 'notify' ,
        function ($location, $log, $modal, $scope, $routeParams, userService, userPageService, notify) {


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


        }]);
