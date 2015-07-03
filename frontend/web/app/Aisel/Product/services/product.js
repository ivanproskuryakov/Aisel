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
    app.service('productService', ['$http', 'Environment',
        function($http, Environment) {
            return {
                getProducts: function(params) {

                    var locale = Environment.currentLocale();
                    var url = Environment.settings.api + '/' + locale + '/product/?limit=' + params.limit + '&current=' + params.page + '&order=' + params.order + '&orderBy=' + params.orderBy + '&category=' + params.categoryId;

                    console.log(url);
                    return $http.get(url);
                },
                getProductByURL: function($url) {

                    var locale = Environment.currentLocale();
                    var url = Environment.settings.api + '/' + locale + '/product/' + $url;

                    console.log(url);
                    return $http.get(url);
                }
            };
        }
    ]);
});
