'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * E2E Test
 */

describe("E2E: Sample e2e test", function() {

    beforeEach(function() {
        browser().navigateTo('/');
    });

    it('Test 1', function() {
//        browser().navigateTo('#!/');
//        console.log(element('#dynamic-content').html());
        console.log(element('body').html());
    });


});g