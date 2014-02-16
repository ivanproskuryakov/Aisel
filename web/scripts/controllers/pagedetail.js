'use strict';

angular.module('projectxApp')
  .controller('PageDetailCtrl', function ($scope, $routeParams, pageService) {

        var pageId = $routeParams.pageId;
        var handleSuccess = function(data, status) {
            $scope.scope = data;
            console.log($scope.scope);
        };
        pageService.getPage(pageId).success(handleSuccess);
  });
