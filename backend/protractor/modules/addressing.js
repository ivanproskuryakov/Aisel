'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * E2E Addressing test
 */

describe("E2E: Addressing module tests", function () {
    console.log('Test loaded: Addressing');
    var ptor = protractor.getInstance();

    it('Addressing Country route is working', function () {
        var testUrl = 'http://admin.aisel.dev/en/addressing/country/';
        browser.get(testUrl);
        var el = element(By.css('.page-header h2'));

        expect(el.getText()).toBe('Countries');

        element(by.css('.ui-grid-canvas button')).click().then(function () {
            ptor.getCurrentUrl().then(function (url) {
                expect(url.indexOf("/addressing/country/edit/")).toBeGreaterThan(0);
            });
        });

    });

    it('Addressing Region route is working', function () {
        var testUrl = 'http://admin.aisel.dev/en/addressing/region/';
        browser.get(testUrl);
        var el = element(By.css('.page-header h2'));

        expect(el.getText()).toBe('Region');

        element(by.css('.ui-grid-canvas button')).click().then(function () {
            ptor.getCurrentUrl().then(function (url) {
                expect(url.indexOf("/addressing/region/edit/")).toBeGreaterThan(0);
            });
        });
    });

    it('Addressing Region route is working', function () {
        var testUrl = 'http://admin.aisel.dev/en/addressing/city/';
        browser.get(testUrl);
        var el = element(By.css('.page-header h2'));

        expect(el.getText()).toBe('City');

        element(by.css('.ui-grid-canvas button')).click().then(function () {
            ptor.getCurrentUrl().then(function (url) {
                expect(url.indexOf("/addressing/city/edit/")).toBeGreaterThan(0);
            });
        });
    });

});