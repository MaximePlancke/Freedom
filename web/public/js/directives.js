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
                // console.log(scope.alreadyLikedStep);
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

ObjectiveApp.directive('allowFollowObjective', function(Objective, $rootScope) {
    return {
        restrict: 'E',
        scope: {
            objective : '=objective',
            userLogged : '=userLogged'
        },
        link: function(scope, element, attrs) { 
            scope.$watch('objective', function() {
                scope.alreadyFollowedObjective = false; 
                scope.icon = "glyphicon-star-empty"; 
                angular.forEach(scope.objective.userfollowobjectives, function(value, key) {
                    if (value.user.id == scope.userLogged) {
                        scope.userfollow = value;
                        scope.alreadyFollowedObjective = true; 
                        scope.icon = "glyphicon-star";  
                    };
                });
            });
            scope.followObjective = function(id){
                var objective = scope.objective;
                if(scope.alreadyFollowedObjective) {
                    Objective.disfollow({id: id, id_follow: scope.userfollow.id},{});
                    var index = scope.objective.userfollowobjectives.indexOf(scope.userfollow);
                    scope.objective.userfollowobjectives.splice(index, 1);
                    scope.icon = "glyphicon-star-empty";
                    if(attrs.followpage){
                        // IMPORTANT Remove this objective from the array
                        $rootScope.flashMessage = {type: 'alert-success', message: 'You don\'t follow this objective anymore !'};
                    }
                } else {
                    var follow = Objective.follow({id: id},{});
                    scope.objective.userfollowobjectives.push(follow);
                    scope.userfollow = follow;
                    scope.icon = "glyphicon-star";  
                } 
                scope.alreadyFollowedObjective = !scope.alreadyFollowedObjective;
            }

        },
        template: '<span ng-click="followObjective(objective.id)" class="clickable glyphicon {{icon}}"></span>'
    };
});

ObjectiveApp.directive('allowBelongGroup', function(Group, $rootScope) {
    return {
        restrict: 'E',
        scope: {
            group : '=group',
            userLogged : '=userLogged',
            alreadyBelongGroup : '=alreadyBelongGroup'
        },
        link: function(scope, element, attrs) { 
            scope.$watch('group', function() {
                scope.alreadyBelongGroup = false; 
                scope.icon = "glyphicon-star-empty"; 
                angular.forEach(scope.group.userbelonggroups, function(value, key) {
                    if (value.user.id == scope.userLogged) {
                        scope.userbelong = value;
                        scope.alreadyBelongGroup = true; 
                        scope.icon = "glyphicon-star";  
                    };
                });
            });
            scope.belongGroup = function(id){
                var group = scope.group;
                if(scope.alreadyBelongGroup) {
                    if (scope.userbelong.role == 1) {
                        $rootScope.flashMessage = {type: 'alert-warning', message: 'You can\'t leave your own group!'};
                    }else{
                        Group.unbelong({id: id, id_belong: scope.userbelong.id},{});
                        var index = scope.group.userbelonggroups.indexOf(scope.userbelong);
                        scope.group.userbelonggroups.splice(index, 1);
                        scope.icon = "glyphicon-star-empty";
                        $rootScope.flashMessage = {type: 'alert-success', message: 'You don\'t belong this group anymore !'};
                    }
                } else {
                    var belong = Group.belong({id: id},{});
                    scope.group.userbelonggroups.push(belong);
                    scope.userbelong = belong;
                    scope.icon = "glyphicon-star";  
                } 
                scope.alreadyBelongGroup = !scope.alreadyBelongGroup;
            }

        },
        template: '<span ng-click="belongGroup(group.id)" class="clickable glyphicon {{icon}}"></span>'
    };
});

ObjectiveApp.directive('submitAdvice', function(Advice) {
    return {
    	restrict: 'A',
        scope: {
            objective : '=objective',
        },
    	link: function(scope, element, attrs) {
    		element.bind("keydown keypress", function(event) {
                if(event.which === 13) {
                    // console.log(attrs);
                    var advice = new Advice;
                    advice.name = element.val();
                    Advice.create({id: scope.objective.id}, advice, function(data){
                        Advice.query({id: scope.objective.id, id_advice: data.id},{}, function(data){ 
                            scope.objective.advices.push(data);
                        });
                    });
                    element.val('');
                    event.preventDefault();
                    // console.log(scope.objective);
                }
            });
    	}
    };
});

// ObjectiveApp.directive("checkboxCategories", function () {
//     return {
//         restrict: "A",
//         link: function (scope, elem, attrs) {
//             if (scope.search.objective.category.indexOf(scope.category.key) !== -1) {
//                 elem[0].checked = true;
//             }

//             elem.bind('click', function () {
//                 var index = scope.search.objective.category.indexOf(scope.category.key);
//                 if (elem[0].checked) {
//                     if (index === -1) scope.search.objective.category.push(scope.category.key);
//                 }
//                 else {
//                     if (index !== -1) scope.search.objective.category.splice(index, 1);
//                 }
//                 scope.$apply(scope.search.objective.category.sort(function (a, b) {
//                     return a - b;
//                 }));
//             });
//         }
//     }
// });