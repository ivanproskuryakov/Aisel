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
    app.controller('ContactCtrl', ['$location', '$scope', 'contactService', 'settingsService', 'notify',
        function ($location, $scope, contactService, settingsService, notify) {

            $scope.config = false;

            settingsService.getApplicationConfig().success(
                function (data, status) {
                    $scope.config = JSON.parse(data.config_contact);
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