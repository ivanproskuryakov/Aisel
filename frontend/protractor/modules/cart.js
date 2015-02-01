'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * E2E Cotact test
 */

describe("E2E: Cart module tests", function () {
    console.log('E2E module loaded: Cart');

    it('Cart in route is working', function () {
        browser.get('http://ecommerce.aisel.dev/en/cart/');
        expect(browser.getTitle()).toEqual('Aisel - open source project');
    });

});