'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * E2E Category listing
 */

describe("E2E: Check that user registration page is working", function() {

    beforeEach(function() {
        browser().navigateTo('/#!/user/register/');
    });

    it('We should have a working /user/register/ route', function() {
        expect(browser().location().path()).toBe("/user/register/");
    });
});