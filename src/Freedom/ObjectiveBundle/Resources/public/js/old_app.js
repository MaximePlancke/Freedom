var ObjectiveApp = angular.module('ObjectiveApp', ['ngResource']);

var pathArray = window.location.pathname.split( '/' );

ObjectiveApp.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
}
);

ObjectiveApp.filter('capitalize', function() {
    return function(input, scope) {
        if (input!=null) {
            return input.substring(0,1).toUpperCase()+input.substring(1);
        }
    }
});

ObjectiveApp.factory('Advice', ['$resource', function($resource){
    return $resource('/api/advices/:id/:action', { id: '@id', action: '@action'}, {
        save: {method:'POST', params:{}},
        delete: {method:'GET', params:{}},
        // query: {method: 'GET', params:{}},
    });
}]);

ObjectiveApp.factory('Objective', ['$resource', function($resource){
    return $resource('/api/objectives/:id/:action', { id: '@id', action: '@action'}, {
        delete: {method:'GET', params:{}},
        query: {method: 'GET', params:{}},
        update: {method: 'PUT', params:{}},
    });
}]);


ObjectiveApp.directive('submitAdvice', function(Advice) {
    return {
    	restrict: 'A',
    	link: function(scope, element, attrs) {
    		element.bind("keydown keypress", function(event) {
                if(event.which === 13) {
                    var advice = Advice.save({},{'message': element.val(), 'idObjective': parseInt(pathArray[2])});
                    scope.objective.advices.push(advice);
                    element.val('');
                    event.preventDefault();
                }
            });
    	}
    };
});


// ObjectiveApp.factory('getObjectiveFactory', [ '$http', '$q', function($http, $q) {
//  return{
//     getObjective : function(id) {
//     	var deferred = $q.defer();
//       $http.get('/api/objectives/' + id)
//       .success(function(data) { 
//         deferred.resolve({
//            objective: data.objective,
//        });
//     }).error(function(msg, code) {
//         deferred.reject(msg);
//       		// $log.error(msg, code);
//          });
//     return deferred.promise;
// }
// }
// }]);


ObjectiveApp.controller('ObjectiveDetailsCtrl', [ '$scope', 'Advice' , 'Objective', function ($scope, Advice, Objective) {

    //Init
    $scope.objective = [];

    $scope.objective = Objective.query({id: parseInt(pathArray[2])},{});

    $scope.deleteObjective = function(id){
        Objective.delete({id: id, action : 'remove'},{});
        document.location.href="/";
    }

    $scope.doneObjective = function(id){
        $scope.objective = Objective.update({id: id},{});
    }

    $scope.deleteAdvice = function(idx){
        var advice = $scope.objective.advices[idx];
        Advice.delete({id: advice.id, action : 'remove'},{});
        $scope.objective.advices.splice(idx,1);
    }

}]);

