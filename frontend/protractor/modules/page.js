'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * E2E Page test
 */

describe("E2E: Page module tests", function() {
    console.log('Test loaded: Page');

    it('Page route is working', function() {
        browser.get('http://aisel.dev/en/pages/');
        expect(browser.getTitle()).toEqual('Aisel - open source project');
    });

    it('Page categories route is working', function() {
        browser.get('http://aisel.dev/en/page/categories/');
        expect(browser.getTitle()).toEqual('Aisel - open source project');
    });

    it('View category route is working', function() {
        browser.get('http://aisel.dev/en/page/categories/');

        element(by.css('.pageList h2 a')).click().then(function() {
            browser.getCurrentUrl().then(function(url) {
                expect(url.indexOf("/page/category/")).toBeGreaterThan(0);
                expect(element(By.css('.page-header h2')).getText()).not.toBeNull();
            });
        });
    });

    it('About Us page route is working', function() {
        browser.get('http://aisel.dev/en/page/view/en-about-aisel/');
        expect(browser.getTitle()).toEqual('About Us');
    });
});
