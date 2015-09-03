'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * E2E Product test
 */

describe("E2E: Product module tests", function() {
    console.log('Test loaded: Products');
    var urlToCheck = 'http://admin.aisel.dev/en/products/';
    var textToCheck = 'Products';

    // == Collection route ==
    it('Collection route is working', function() {
        browser.get(urlToCheck);
        var el = element(By.css('.page-header h2'));

        expect(el.getText()).toBe(textToCheck);
    });

    // == Edit item route ==
    it('Edit route is working', function() {
        browser.get(urlToCheck);

        element(by.css('.ui-grid-canvas button')).click().then(function() {
            browser.getCurrentUrl().then(function(url) {
                expect(url.indexOf("/edit/")).toBeGreaterThan(0);
            });
        });
    });

    // == New item route ==
    it('New item route is working', function() {
        browser.get(urlToCheck);

        element(by.css('.add-new-item')).click().then(function() {
            browser.getCurrentUrl().then(function(url) {
                expect(url.indexOf("/new/")).toBeGreaterThan(0);
            });
        });
    });

    // == Page node route ==
    it('Page nodes route is working', function() {
        browser.get('http://admin.aisel.dev/en/product/node/en/');

        element(by.css('.glyphicon-edit')).click().then(function() {
            browser.getCurrentUrl().then(function(url) {
                expect(url.indexOf("/edit/en/")).toBeGreaterThan(0);
            });
        });
    });

});
