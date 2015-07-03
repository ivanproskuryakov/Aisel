'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * E2E Contact test
 */

describe("E2E: Contact module tests", function() {
    console.log('Test loaded: Contact');

    it('Contact route is working', function() {
        browser.get('http://aisel.dev/en/contact/');
        expect(browser.getTitle()).toEqual('Aisel - open source project');
    });
});
