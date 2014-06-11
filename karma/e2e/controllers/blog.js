'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * E2E Blog listing
 */

describe("E2E: Check blog listing page is working", function() {

    beforeEach(function() {
        browser().navigateTo('/#!/pages/');
    });

    it('We should have a working /pages/ route', function() {
        expect(browser().location().path()).toBe("/pages/");
    });

    it('Check that page contains at least 1 article and pagination is working', function() {
        expect(element('.pageList li').count()).toBeGreaterThan(0);
        element('.pagination li:eq(2) a').click();
        expect(element('.pull-right.pagination').html()).toContain('Current: 2');
    });

});