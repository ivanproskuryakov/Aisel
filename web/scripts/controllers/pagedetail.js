'use strict';

angular.module('aiselApp')
  .controller('PageDetailCtrl', function ($scope, $routeParams, pageService,$rootScope) {



        var pageId = $routeParams.pageId;
        var handleSuccess = function(data, status) {

            $scope.pageDetails = data;
            $rootScope.pageTitle = $scope.pageDetails.page.title;

        };
        pageService.getPage(pageId).success(handleSuccess);
  });
