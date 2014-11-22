'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * E2E Search test
 */

describe("E2E: We check that our app is feeling nice", function () {
    console.log('E2E module loaded: Search');

    it('should have a title', function () {
        browser.get('http://ecommerce.aisel.dev/en/search/mockup');
        expect(browser.getTitle()).toEqual('Aisel - open source project');
    });
});