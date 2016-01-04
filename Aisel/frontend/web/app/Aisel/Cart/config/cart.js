'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselCart
 * @description     Module configuration
 */

define(['app'], function(app) {
    app.config(['$stateProvider', function($stateProvider) {
        $stateProvider
            .state("cart", {
                url: "/:locale/cart/",
                templateUrl: '/app/Aisel/Cart/views/cart.html',
                controller: 'CartCtrl'
            });
    }]);
});
