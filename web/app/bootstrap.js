'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * Application core module
 */

define([
    'require',
    'angular',
    'app',
    './local/router',
    './Aisel/Resource/services/root',
    './Aisel/Homepage/router',
    './Aisel/Contact/router',
    './Aisel/Search/router',
    './Aisel/Page/router'
], function (require, angular) {
    'use strict';

    require(['domReady!'], function (document) {
        console.log('----------- Bootstrapping the App -----------');
        angular.bootstrap(document, ['app']);
    });
});