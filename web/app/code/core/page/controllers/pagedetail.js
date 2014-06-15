'use strict';

angular.module('aiselApp')
  .controller('PageDetailCtrl', function ($scope, $routeParams, pageService,$rootScope) {

        var pageURL = $routeParams.pageId;

        var handleSuccess = function(data, status) {
            $scope.pageDetails = data;
            $rootScope.pageTitle = $scope.pageDetails.page.title;
        };
        pageService.getPageByURL(pageURL).success(handleSuccess);

  });
