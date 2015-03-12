'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * E2E Backend User test
 */

describe("E2E: Backend User module tests", function () {
    console.log('Test loaded: Backend Users');
    var ptor = protractor.getInstance();
    var testUrl = 'http://admin.aisel.dev/en/users/backend/';

    it('Backend User route is working', function () {
        browser.get(testUrl);
        var el = element(By.css('.page-header h2'));

        expect(el.getText()).toBe('Backend Users');

        element(by.css('.ui-grid-canvas button')).click().then(function () {
            ptor.getCurrentUrl().then(function (url) {
                expect(url.indexOf("/users/backend/view/")).toBeGreaterThan(0);
            });
        });
    });

});