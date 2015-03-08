'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * E2E User test
 */

describe("E2E: User module tests", function () {
    console.log('Test loaded: User');

    it('Sign in route is working', function () {
        browser.get('http://admin.aisel.dev/en/user/login/');
        var el = element(by.css('.page-header'));
        expect((el).isDisplayed()).toBeTruthy();
    });
});