'use strict';

angular.module('projectxApp')
    .directive('ngSearchRedirect',["$location", function ($location) {
    return {
        restrict: 'A',
        link: function postLink(scope, element, attrs) {
            element.bind("keyup", function (e) {
                if (e.keyCode === 13) {
                    if(attrs.ngSearchRedirect.length > 1){
                        window.location.assign('#!/search/'+attrs.ngSearchRedirect);
                    }
//                        else {
//                            alert('Search query should have 3 or more letters');
//                            e.preventDefault();
//                            return;
//                        }

                }
            });
        }
    };
}])
