var ObjectiveApp = angular.module('ObjectiveApp', ['ngResource']);

var pathArray = window.location.pathname.split( '/' );

ObjectiveApp.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
}
);

// ObjectiveApp.filter('numberofdays', function() {
//     return function(input, scope) {
//         if (input.done == true) {
//             return 'Done';
//         }
//         var now = new Date();
//         var date = Date.parse(input.dategoal);
//         var diff = (date - now);
//         diff = Math.ceil(diff/(1000 * 3600 * 24));
//         if(diff == 0) { diff = 'Today!';}
//         else
//         if(diff < 0) {diff = 'Too late!';}
//         else { diff = diff+' days left';}
        
//         return diff;
//     }
// });

ObjectiveApp.filter('capitalize', function() {
    return function(input, scope) {
        if (input!=null) {
            return input.substring(0,1).toUpperCase()+input.substring(1);
        }
    }
});

ObjectiveApp.factory('Objective', ['$resource', function($resource){
    return $resource('/api/objectives/:id', { id: '@id'}, {
        delete: {method:'DELETE', params:{}},
        query: {method: 'GET', params:{}},
        update: {method: 'PUT', params:{}},
        like: {method: 'POST', url: '/api/objectives/:id/userlikeobjectives', params:{}},
        dislike: {method: 'DELETE', url: '/api/objectives/:id/userlikeobjectives/:id_like', params:{}}
    });
}]);

ObjectiveApp.factory('Step', ['$resource', function($resource){
    return $resource('/api/stepobjectives/:id', { id: '@id'}, {
        delete: {method:'DELETE', url: '/api/objectives/:id/stepobjectives/:id_step', params:{}},
        update: {method: 'PUT', url: '/api/objectives/:id/stepobjectives/:id_step',params:{}},
        like: {method: 'POST', url: '/api/objectives/:id/stepobjectives/:id_step/userlikestepobjectives', params:{}},
        dislike: {method: 'DELETE', url: '/api/objectives/:id/stepobjectives/:id_step/userlikestepobjectives/:id_like', params:{}}
    });
}]);

ObjectiveApp.factory('Advice', ['$resource', function($resource){
    return $resource('/api/objectives/:id/advices/:id_advice', { id: '@id'}, {
        query: {method: 'GET', params:{}},
        create: {method: 'POST', url: '/api/objectives/:id/advices', params:{}},
        delete: {method:'DELETE', url: '/api/objectives/:id/advices/:id_advice',params:{}},
        update: {method: 'PUT', url: '/api/objectives/:id/advices/:id_advice',params:{}},
        like: {method: 'POST', url: '/api/objectives/:id/advices/:id_advice/userlikeadvices', params:{}},
        dislike: {method: 'DELETE', url: '/api/objectives/:id/advices/:id_advice/userlikeadvices/:id_like', params:{}}
    });
}]);

ObjectiveApp.directive('allowLikeObjective', function(Objective) {
    return {
        restrict: 'E',
        scope: {
            objective : '=objective',
            userLogged : '=userLogged'
        },
        link: function(scope, element, attrs) { 
            scope.$watch('objective', function() {
                scope.alreadyLikedObjective = false; 
                scope.icon = "glyphicon-heart-empty"; 
                angular.forEach(scope.objective.userlikeobjectives, function(value, key) {
                    if (value.user.id == scope.userLogged) {
                        scope.userlike = value;
                        scope.alreadyLikedObjective = true; 
                        scope.icon = "glyphicon-heart";  
                    };
                });
            });
            scope.likeObjective = function(id){
                var objective = scope.objective;
                if(scope.alreadyLikedObjective) {
                    Objective.dislike({id: id, id_like: scope.userlike.id},{});
                    var index = scope.objective.userlikeobjectives.indexOf(scope.userlike);
                    scope.objective.userlikeobjectives.splice(index, 1);
                    scope.icon = "glyphicon-heart-empty";
                } else {
                    var like = Objective.like({id: id},{});
                    scope.objective.userlikeobjectives.push(like);
                    scope.userlike = like;
                    scope.icon = "glyphicon-heart";  
                } 
                scope.alreadyLikedObjective = !scope.alreadyLikedObjective;
            }

        },
        template: '<span ng-click="likeObjective(objective.id)" class="clickable glyphicon {{icon}}"></span>'
    };
});

ObjectiveApp.directive('allowLikeAdvice', function(Advice) {
    return {
        restrict: 'E',
        scope: {
            objective : '=objective',
            userLogged : '=userLogged',
            idx : '=idx'
        },
        link: function(scope, element, attrs) {
            scope.$watch('objective', function() {
                scope.alreadyLikedAdvice = []; // Not clean code
                scope.alreadyLikedAdvice[scope.idx] = false; 
                scope.icon = "glyphicon-heart-empty"; 
                angular.forEach(scope.objective.advices[scope.idx].userlikeadvices, function(value, index) {
                    if (value.user.id == scope.userLogged) {
                        scope.userlike = value;
                        scope.alreadyLikedAdvice[scope.idx] = true; 
                        scope.icon = "glyphicon-heart";  
                    };
                });
                console.log(scope.alreadyLikedAdvice);
            });
            scope.likeAdvice = function(){
                var idx = scope.idx;
                var advice = scope.objective.advices[idx];
                if(scope.alreadyLikedAdvice[idx]) {
                    Advice.dislike({id: scope.objective.id, id_advice: advice.id, id_like: scope.userlike.id},{});
                     var index = scope.objective.advices[idx].userlikeadvices.indexOf(scope.userlike);
                    scope.objective.advices[idx].userlikeadvices.splice(index, 1);
                    scope.icon = "glyphicon-heart-empty";
                } else {
                    var like = Advice.like({id: scope.objective.id, id_advice: advice.id},{});
                    scope.objective.advices[idx].userlikeadvices.push(like);
                    scope.userlike = like;
                    scope.icon = "glyphicon-heart";  
                } 
                scope.alreadyLikedAdvice[idx] = !scope.alreadyLikedAdvice[idx];
            }

        },
        template: '<span ng-click="likeAdvice()" class="clickable glyphicon {{icon}}"></span>'
    };
});

ObjectiveApp.directive('allowLikeStep', function(Step) {
    return {
        restrict: 'E',
        scope: {
            objective : '=objective',
            userLogged : '=userLogged',
            idx : '=idx'
        },
        link: function(scope, element, attrs) {
            scope.$watch('objective', function() {
                scope.alreadyLikedStep = []; // Not clean code
                scope.alreadyLikedStep[scope.idx] = false; 
                scope.icon = "glyphicon-heart-empty"; 
                angular.forEach(scope.objective.steps[scope.idx].userlikestepobjectives, function(value, index) {
                    if (value.user.id == scope.userLogged) {
                        scope.userlike = value;
                        scope.alreadyLikedStep[scope.idx] = true; 
                        scope.icon = "glyphicon-heart";  
                    };
                });
                console.log(scope.alreadyLikedStep);
            });
            scope.likeStep = function(){
                var idx = scope.idx;
                var step = scope.objective.steps[idx];
                if(scope.alreadyLikedStep[idx]) {
                    Step.dislike({id: scope.objective.id, id_step: step.id, id_like: scope.userlike.id},{});
                     var index = scope.objective.steps[idx].userlikestepobjectives.indexOf(scope.userlike);
                    scope.objective.steps[idx].userlikestepobjectives.splice(index, 1);
                    scope.icon = "glyphicon-heart-empty";
                } else {
                    var like = Step.like({id: scope.objective.id, id_step: step.id},{});
                    scope.objective.steps[idx].userlikestepobjectives.push(like);
                    scope.userlike = like;
                    scope.icon = "glyphicon-heart";  
                } 
                scope.alreadyLikedStep[idx] = !scope.alreadyLikedStep[idx];
            }

        },
        template: '<span ng-click="likeStep()" class="clickable glyphicon {{icon}}"></span>'
    };
});

ObjectiveApp.directive('submitAdvice', function(Advice) {
    return {
    	restrict: 'A',
    	link: function(scope, element, attrs) {
    		element.bind("keydown keypress", function(event) {
                if(event.which === 13) {
                    var advice = new Advice;
                    advice.name = element.val();
                    Advice.create({id: parseInt(pathArray[2])}, advice, function(data){
                        Advice.query({id: parseInt(pathArray[2]), id_advice: data.id},{}, function(data){ 
                            scope.objective.advices.push(data);
                        });
                    });
                    element.val('');
                    event.preventDefault();
                    console.log(scope.objective)
                }
            });
    	}
    };
});


ObjectiveApp.controller('ObjectiveDetailsCtrl', [ '$scope', 'Advice' , 'Objective', 'Step', '$filter', function ($scope, Advice, Objective, Step, $filter) {

    //Init
    $scope.objective = [];

    Objective.query({id: parseInt(pathArray[2])},{}, function(data){
        $scope.objective = data;
    });

    Advice.query({id: parseInt(pathArray[2]), id_advice: 2},{}, function(data){
        console.log(data);
    });

    $scope.deleteObjective = function(id){
        Objective.delete({id: id},{});
        document.location.href="/";
    }

    $scope.doneObjective = function(id){
        var objective = $scope.objective;
        objective.done = !objective.done;
        var now = $filter('date')(new Date(), 'yyyy/MM/dd hh:mm:ss');
        objective.datedone = now;
        $scope.objective = Objective.update({id: id}, objective);
    }


    $scope.deleteStep = function(idx){
        var step = $scope.objective.steps[idx];
        Step.delete({id: $scope.objective.id, id_step: step.id},{});
        $scope.objective.steps.splice(idx,1);

    }

    $scope.doneStep = function(idx){
        var step = $scope.objective.steps[idx];
        step.done = !step.done;
        $scope.objective.steps[idx] = Step.update({id: $scope.objective.id , id_step: step.id},step);
    }

    $scope.likeAdvice = function(idx){
        var advice = $scope.objective.advices[idx];;
        if($scope.alreadyLikedAdvice) {
            advice.likes--; 
        } else {
            advice.likes++; 
        } 
        $scope.alreadyLikedAdvice = !$scope.alreadyLikedAdvice;
        $scope.objective.advices[idx] = Advice.update({id: $scope.objective.id, id_advice: advice.id},advice);
    }

    $scope.deleteAdvice = function(idx){
        var advice = $scope.objective.advices[idx];
        Advice.delete({id: $scope.objective.id, id_advice: advice.id},{});
        $scope.objective.advices.splice(idx,1);
    }

}]);

