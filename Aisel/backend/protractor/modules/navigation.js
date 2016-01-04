'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * E2E Navigation test
 */

describe("E2E: Navigation module tests", function() {
    console.log('Test loaded: Navigation');
    var urlToCheck = 'http://admin.aisel.dev/en/navigation/en/';
    var textToCheck = 'Navigation';

    // == Collection route ==
    it('Collection route is working', function() {
        browser.get(urlToCheck);
        var el = element(By.css('.page-header h2'));

        expect(el.getText()).toBe(textToCheck);
    });

    // == Edit item route ==
    it('Edit route is working', function() {
        browser.get(urlToCheck);

        element(by.css('.glyphicon-edit')).click().then(function() {
            browser.getCurrentUrl().then(function(url) {
                expect(url.indexOf("/edit/en/")).toBeGreaterThan(0);
            });
        });
    });


});
