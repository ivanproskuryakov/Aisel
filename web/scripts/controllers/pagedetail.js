'use strict';

angular.module('projectxApp')
  .controller('PageDetailCtrl', function ($scope, $routeParams, pageService,$rootScope) {



        var pageId = $routeParams.pageId;
        var handleSuccess = function(data, status) {
            $scope.pageDetails = data;

            $rootScope.pageTitle = $scope.pageDetails.page.title;
            $rootScope.metaDescription = $scope.pageDetails.page.meta_title;
            $rootScope.metaKeywords = $scope.pageDetails.page.meta_title;

            if ($scope.pageDetails.page.meta_title) {
                $rootScope.pageTitle = $scope.pageDetails.page.meta_title;
            }

        };
        pageService.getPage(pageId).success(handleSuccess);
  });
