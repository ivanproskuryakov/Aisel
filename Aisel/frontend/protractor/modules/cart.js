'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * E2E Cart test
 */

describe("E2E: Cart module tests", function() {
    console.log('Test loaded: Cart');

    it('Cart in route is working', function() {
        browser.get('http://aisel.dev/en/cart/');
        expect(browser.getTitle()).toEqual('Aisel - open source project');
    });

});
