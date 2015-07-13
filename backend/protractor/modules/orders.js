'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * E2E Order test
 */

describe("E2E: Order module tests", function() {
    console.log('Test loaded: Orders');
    var testUrl = 'http://admin.aisel.dev/en/orders/';

    it('Order route is working', function() {
        browser.get(testUrl);
        var el = element(By.css('.page-header h2'));

        expect(el.getText()).toBe('Orders');

        element(by.css('.ui-grid-canvas button')).click().then(function() {
            browser.getCurrentUrl().then(function(url) {
                expect(url.indexOf("/order/edit/")).toBeGreaterThan(0);
            });
        });
    });

});
