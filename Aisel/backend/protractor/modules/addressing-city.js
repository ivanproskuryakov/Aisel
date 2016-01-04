'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * E2E Addressing City test
 */

describe("E2E: Addressing module tests", function() {
    console.log('Test loaded: Addressing City');
    var urlToCheck = 'http://admin.aisel.dev/en/addressing/city/';
    var textToCheck = 'Cities';

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

});
