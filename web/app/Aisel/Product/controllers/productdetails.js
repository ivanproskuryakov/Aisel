'use strict';

/**
 * @ngdoc overview
 * @name Aisel
 *
 * @description
 * ...
 */

define(['app'], function (app) {
    app.controller('ProductDetailCtrl', function ($scope, $routeParams, productService, $rootScope) {
        var productURL = $routeParams.productId;
        var handleSuccess = function (data, status) {
            $scope.productDetails = data;
            $rootScope.productTitle = $scope.productDetails.product.title;

            // Disqus comments
            window.disqus_shortname = $rootScope.disqusShortname;
            $scope.showComments = $rootScope.disqusStatus && $scope.productDetails.product.comment_status;
        };
        productService.getPageByURL(productURL).success(handleSuccess);
    });
});