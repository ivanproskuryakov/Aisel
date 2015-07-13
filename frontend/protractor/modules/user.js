'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * E2E User test
 */

describe("E2E: User module tests", function() {
    console.log('Test loaded: User');

    it('Sign in route is working', function() {
        browser.get('http://aisel.dev/en/user/login/');
        expect(browser.getTitle()).toEqual('Aisel - open source project');
    });

    it('Create Account route is working', function() {
        browser.get('http://aisel.dev/en/user/register/');
        expect(browser.getTitle()).toEqual('Aisel - open source project');
    });
    it('Password forgot route is working', function() {
        browser.get('http://aisel.dev/en/user/password/forgot/');
        expect(browser.getTitle()).toEqual('Aisel - open source project');
    });
});
