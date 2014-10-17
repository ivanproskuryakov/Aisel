'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * ...
 */

define(['app'], function (app) {
    app.service('pageService', ['$http', '$routeParams', 'API_URL',
        function ($http, $routeParams, API_URL) {
            return {
                getPages: function ($scope) {
                    var locale = Aisel.settings.locale.primary;
                    var url = API_URL + '/' + locale + '/page/list.json?limit=' + $scope.pageLimit + '&current=' + $scope.paginationPage + '&category=' + $scope.categoryId;
                    console.log(url);
                    return $http.get(url);
                },
                getPageByURL: function ($url) {
                    var locale = Aisel.settings.locale.primary;
                    var url = API_URL + '/' + locale + '/page/view/url/' + $url + '.json';
                    console.log(url);
                    return $http.get(url);
                }
            };
        }]);
});