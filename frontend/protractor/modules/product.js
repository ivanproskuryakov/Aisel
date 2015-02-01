'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * E2E Product test
 */

describe("E2E: Product module tests", function () {
    console.log('E2E module loaded: Product');

    it('Product route is working', function () {
        browser.get('http://ecommerce.aisel.dev/en/products/');
        expect(browser.getTitle()).toEqual('Aisel - open source project');
    });

    it('Product categories route is working', function () {
        browser.get('http://ecommerce.aisel.dev/en/product/categories/');
        expect(browser.getTitle()).toEqual('Aisel - open source project');
    });

    it('Product page route is working', function () {
        browser.get('http://ecommerce.aisel.dev/en/product/view/en-nike-baseball-hat-12/');
        expect(browser.getTitle()).toEqual('Aisel - open source project');
    });
});