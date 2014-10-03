'use strict';

angular.module('aiselApp')
    .directive('ngSearchRedirect',['$location', function ($location) {
    return {
        restrict: 'A',
        link: function postLink(scope, element, attrs) {
            element.bind('keyup', function (e) {
                if (e.keyCode === 13) {
                    if(attrs.ngSearchRedirect.length > 1){
                        window.location.assign('/#/en/search/'+attrs.ngSearchRedirect);
                    }
                }
            });
        }
    };
}]);
