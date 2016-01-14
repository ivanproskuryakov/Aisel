'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * E2E Search test
 */

describe("E2E: We check that our app is feeling nice", function() {
    console.log('Test loaded: Search');

    it('should have a title', function() {
        browser.get('http://aisel.dev/en/search/mockup');
        expect(browser.getTitle()).toEqual('Aisel - open source project');
    });
});
