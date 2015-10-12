'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselProduct
 * @description     ...
 */

define(['app'], function(app) {
    app.service('productCategoryService', ['$http', 'Environment',
        function($http, Environment) {
            return {
                getCollection: function(params) {
                    var locale = Environment.currentLocale();
                    var url = Environment.settings.api + '/' +
                        locale + '/product/node/?limit=' + params.limit +
                        '&current=' + params.page +
                        '&order=' + params.order +
                        '&orderBy=' + params.orderBy;

                    console.log(url);
                    return $http.get(url);
                },
                getProductCategoryTree: function() {
                    var locale = Environment.currentLocale();
                    var url = Environment.settings.api + '/' + locale + '/product/node/tree/';
                    console.log(url);
                    return $http.get(url);
                }
            };
        }
    ]);
});
