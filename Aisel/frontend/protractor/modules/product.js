'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * E2E Product test
 */

describe("E2E: Product module tests", function() {
    console.log('Test loaded: Product');

    it('Product route is working', function() {
        browser.get('http://aisel.dev/en/products/');
        expect(browser.getTitle()).toEqual('Aisel - open source project');
    });

    it('Product categories route is working', function() {
        browser.get('http://aisel.dev/en/product/categories/');
        expect(browser.getTitle()).toEqual('Aisel - open source project');
    });

    it('View category route is working', function() {
        browser.get('http://aisel.dev/en/product/categories/');

        element(by.css('.pageList h2 a')).click().then(function() {
            browser.getCurrentUrl().then(function(url) {
                expect(url.indexOf("/product/category/")).toBeGreaterThan(0);
                expect(element(By.css('.page-header h2')).getText()).not.toBeNull();
            });
        });
    });

    it('Product page route is working', function() {
        browser.get('http://aisel.dev/en/product/view/en-nike-baseball-hat-12/');
        expect(browser.getTitle()).toEqual('Aisel - open source project');
    });
});
