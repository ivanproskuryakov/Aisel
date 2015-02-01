'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * E2E Cotact test
 */

describe("E2E: Contact module tests", function () {
    console.log('E2E module loaded: Contact');

    it('Contact route is working', function () {
        browser.get('http://ecommerce.aisel.dev/en/contact/');
        expect(browser.getTitle()).toEqual('Aisel - open source project');
    });
});