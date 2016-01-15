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
 * @description     contactService
 */

define(['app'], function (app) {
    app.service('contactService', ['$http', 'Env',
        function ($http, Env) {
            return {
                send: function (form) {
                    var data = {
                        name: form.name.$modelValue,
                        email: form.email.$modelValue,
                        phone: form.phone.$modelValue,
                        message: form.message.$modelValue
                    };
                    var url = Env.api + '/contact/form/';
                    return $http.post(
                        url,
                        data
                    );
                }
            };
        }
    ]);
});
