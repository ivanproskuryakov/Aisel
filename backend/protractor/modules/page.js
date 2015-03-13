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
    var ptor = protractor.getInstance();
    var testUrl = 'http://admin.aisel.dev/en/pages/';

    it('Page route is working', function () {
        browser.get(testUrl);
        var el = element(By.css('.page-header h2'));

        expect(el.getText()).toBe('Pages');

        element(by.css('.ui-grid-canvas button')).click().then(function () {
            ptor.getCurrentUrl().then(function (url) {
                expect(url.indexOf("/page/edit/")).toBeGreaterThan(0);
            });
        });
    });

});