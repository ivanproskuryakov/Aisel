'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * E2E Frontend User test
 */

describe("E2E: Frontend User module tests", function () {
    console.log('Test loaded: Frontend Users');
    var ptor = protractor.getInstance();
    var testUrl = 'http://admin.aisel.dev/en/users/frontend/';

    it('Frontend User route is working', function () {
        browser.get(testUrl);
        var el = element(By.css('.page-header h2'));

        expect(el.getText()).toBe('Frontend Users');

        element(by.css('.ui-grid-canvas button')).click().then(function () {
            ptor.getCurrentUrl().then(function (url) {
                expect(url.indexOf("/users/frontend/view/")).toBeGreaterThan(0);
            });
        });
    });

});