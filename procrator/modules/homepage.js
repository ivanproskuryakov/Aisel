'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * E2E Homepage test
 */

describe("E2E: We check that our app is feeling nice", function () {
    console.log('E2E module testing: homepage');
    it('should have a title', function () {
        browser.get('http://ecommerce.aisel.dev/en/');
        expect(browser.getTitle()).toEqual('Aisel - open source project');
    });
});