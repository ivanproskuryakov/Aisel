'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselKernel
 * @description     resourceService
 */

define(['app'], function (app) {
    app.service('resourceService', ['$http', 'Environment',
        function ($http, Environment) {

            var resourceService = function(name) {
                this.resource = name;
            };

            resourceService.prototype.getCollection = function ($scope, pageNumber) {
                var url = Environment.settings.api
                    + '/'+ this.resource +'/?limit=' + $scope.pageLimit
                    + '&current=' + pageNumber
                    + '&filter=' + $scope.filter;

                console.log(url);
                return $http.get(url);
            };
            resourceService.prototype.remove = function ($id) {
                var url = Environment.settings.api + '/' + this.resource + '/' + $id;
                console.log(url);
                return $http.delete(url);
            };
            resourceService.prototype.get = function ($id) {
                var url = Environment.settings.api + '/' + this.resource + '/' + $id;
                console.log(url);
                return $http.get(url);
            };
            resourceService.prototype.save = function (data) {
                var url = Environment.settings.api + '/' + this.resource + '/' + data.id;
                console.log(data);
                return $http({
                    method: 'PUT',
                    url: url,
                    data: data
                });
            };
            resourceService.prototype.create = function (data) {
                var url = Environment.settings.api + '/' + this.resource + '/';
                return $http({
                    method: 'POST',
                    url: url,
                    data: data
                });
            };
            resourceService.prototype.getCategory = function ($id) {
                var url = Environment.settings.api + '/' + this.resource + '/category/' + $id;
                console.log(url);
                return $http.get(url);
            };


            return resourceService;
        }]);
});