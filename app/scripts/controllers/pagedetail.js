'use strict';

angular.module('projectxApp')
  .controller('PageDetailCtrl', function ($scope, $routeParams, pageService) {
        var pageId = $routeParams.pageId;
        var handleSuccess = function(data, status) {
            $scope.page = data;
        };
        pageService.getPage(pageId).success(handleSuccess);
  });
