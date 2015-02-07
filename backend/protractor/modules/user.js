'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * E2E User test
 */

describe("E2E: User module tests", function () {
    console.log('E2E module loaded: User');

    it('Sign in route is working', function () {
        browser.get('http://admin.ecommerce.aisel.dev/en/user/login/');
        var el = element(by.css('.page-header'));
        expect((el).isDisplayed()).toBeTruthy();
    });
});