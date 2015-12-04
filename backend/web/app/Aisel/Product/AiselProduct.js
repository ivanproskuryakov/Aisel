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
 * @description     Product module
 */

define(['app',
    './config/product',
    './controllers/product',
    './controllers/productDetails',
    './controllers/productNode',
    './controllers/productNodeDetails',
    './controllers/productReview',
    './controllers/productReviewDetails',
    './directives/images',
], function(app) {
    console.log('Product module loaded ...');
});
