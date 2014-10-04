'use strict';

/**
 * @ngdoc overview
 *
 * @name aiselApp
 *
 * @description
 *
 * ...
 */

angular.module('aiselApp')
    .service('userPageService', ['$http', '$routeParams', 'API_URL', function ($http, $routeParams, API_URL) {
        return {

            getPages: function ($scope) {
                var url = API_URL + '/page/list.json?user=true&limit=' + $scope.pageLimit + 'limit=' + $scope.pageLimit + '&current=' + $scope.paginationPage + '&category=' + $scope.categoryId;
                console.log(url);
                return $http.get(url);
            },
            getPageById: function ($id) {
                var url = API_URL + '/user/page/details/id/' + $id + '.json';
                console.log(url);
                return $http.get(url);
            },
            addPage: function (pageDetails, websiteCategories) {
                var url = API_URL + '/user/page/add.json';
                pageDetails.selectedCategories = websiteCategories;
                console.log(url);
                console.log(pageDetails);
                return $http.get(url, {params: {details: pageDetails}});
            },
            savePage: function (pageDetails, websiteCategories) {
                var id = pageDetails.page.id;
                var url = API_URL + '/user/page/edit/' + id + '.json';
                pageDetails.selectedCategories = websiteCategories;
                console.log(url);
                console.log(pageDetails);
                return $http.get(url, {params: {details: pageDetails}});
            },
            deletePage: function (pageDetails) {
                var id = pageDetails.page.id;
                var url = API_URL + '/user/page/delete/' + id + '.json';
                console.log(url);
                return $http.get(url);
            }
        };

    }]);
