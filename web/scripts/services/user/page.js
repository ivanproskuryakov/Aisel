'use strict';

angular.module('aiselApp')
    .service('userPageService', ['$http', '$routeParams', 'API_URL',function ($http, $routeParams, API_URL) {
        return {

            getPages: function($scope) {
                var url = API_URL+'/page/list.json?userid='+$scope.userId+'&limit='+$scope.pageLimit+'limit='+$scope.pageLimit+'&current='+$scope.paginationPage+'&category='+$scope.categoryId;
                console.log(url);
                return $http.get(url);
            },
            getPageById: function($id) {
                var url = API_URL+'/user/page/details/id/'+$id+'.json';
                console.log(url);
                return $http.get(url);
            },
            addPage: function(pageDetails) {
                pageDetails = '0';
                var url = API_URL+'/user/page/add.json';
                console.log(url);
                return $http.post(url,pageDetails);
            },
            savePage: function(pageDetails) {
                var id = pageDetails.page.id;
                var url = API_URL+'/user/page/edit/'+id+'.json';
                console.log(url);
                return $http.post(url,pageDetails);
            }
        };

    }]);
