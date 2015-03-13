'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * E2E Product test
 */

describe("E2E: Product module tests", function () {
    console.log('Test loaded: Products');
    var ptor = protractor.getInstance();
    var testUrl = 'http://admin.aisel.dev/en/products/';

    it('Product route is working', function () {
        browser.get(testUrl);
        var el = element(By.css('.page-header h2'));

        expect(el.getText()).toBe('Products');

        element(by.css('.ui-grid-canvas button')).click().then(function () {
            ptor.getCurrentUrl().then(function (url) {
                expect(url.indexOf("/product/edit/")).toBeGreaterThan(0);
            });
        });
    });

});