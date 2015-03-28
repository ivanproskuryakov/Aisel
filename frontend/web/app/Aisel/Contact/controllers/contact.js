'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselContact
 * @description     ...
 */

define(['app'], function (app) {
    app.controller('ContactCtrl', ['$location', '$scope', 'contactService', 'settingsService', 'notify', 'Environment',
        function ($location, $scope, contactService, settingsService, notify, Environment) {

            $scope.config = false;

            settingsService.getApplicationConfig().success(
                function (data, status) {
                    var locale = Environment.currentLocale();
                    var contact = data.settings[locale].config_contact;
                    $scope.config = JSON.parse(contact);
                }
            );

            // Submit Contact
            $scope.submitContact = function (form) {
                if (form.$valid) {
                    contactService.send(form).success(
                        function (data, status) {
                            notify(data.message);
                        }
                    );
                }
            };

        }]);
});