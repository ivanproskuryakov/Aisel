'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * E2E Page test
 */

describe("E2E: Page module tests", function () {
    console.log('Test loaded: Page');

    it('Page route is working', function () {
        browser.get('http://aisel.dev/en/page/');
        expect(browser.getTitle()).toEqual('Aisel - open source project');
    });

    it('Page categories route is working', function () {
        browser.get('http://aisel.dev/en/page/categories/');
        expect(browser.getTitle()).toEqual('Aisel - open source project');
    });

    it('About Us page route is working', function () {
        browser.get('http://aisel.dev/en/page/view/en-about-aisel/');
        expect(browser.getTitle()).toEqual('About Us');
    });
});