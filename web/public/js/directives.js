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
                    Objective.dislike({id: id, id_like: scope.userlike.id},{}, function(){
                        var index = scope.objective.userlikeobjectives.indexOf(scope.userlike);
                        scope.objective.userlikeobjectives.splice(index, 1);
                        scope.icon = "glyphicon-heart-empty";
                    });
                } else {
                    Objective.like({id: id},{},function(like){
                        scope.objective.userlikeobjectives.push(like);
                        scope.userlike = like;
                        scope.icon = "glyphicon-heart";  
                    });
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
                    Advice.dislike({id: scope.objective.id, id_advice: advice.id, id_like: scope.userlike.id},{},function(){
                        var index = scope.objective.advices[idx].userlikeadvices.indexOf(scope.userlike);
                        scope.objective.advices[idx].userlikeadvices.splice(index, 1);
                        scope.icon = "glyphicon-heart-empty";
                    });
                } else {
                    Advice.like({id: scope.objective.id, id_advice: advice.id},{}, function(like){
                        scope.objective.advices[idx].userlikeadvices.push(like);
                        scope.userlike = like;
                        scope.icon = "glyphicon-heart"; 
                    }); 
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
                    Step.dislike({id: scope.objective.id, id_step: step.id, id_like: scope.userlike.id},{},function(){
                        var index = scope.objective.steps[idx].userlikestepobjectives.indexOf(scope.userlike);
                        scope.objective.steps[idx].userlikestepobjectives.splice(index, 1);
                        scope.icon = "glyphicon-heart-empty";
                    });
                } else {
                    Step.like({id: scope.objective.id, id_step: step.id},{},function(like){
                        scope.objective.steps[idx].userlikestepobjectives.push(like);
                        scope.userlike = like;
                        scope.icon = "glyphicon-heart";  
                    });
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
                    Objective.disfollow({id: id, id_follow: scope.userfollow.id},{},function(){
                        var index = scope.objective.userfollowobjectives.indexOf(scope.userfollow);
                        scope.objective.userfollowobjectives.splice(index, 1);
                        scope.icon = "glyphicon-star-empty";
                        if(attrs.followpage){
                            // IMPORTANT Remove this objective from the array
                            $rootScope.flashMessage = {type: 'alert-success', message: 'You don\'t follow this objective anymore !'};
                        }
                    });
                } else {
                    Objective.follow({id: id},{}, function(follow){
                        scope.objective.userfollowobjectives.push(follow);
                        scope.userfollow = follow;
                        scope.icon = "glyphicon-star"; 
                    }); 
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
            userBelong : '=userBelong',
            group : '=group',
            alreadyBelongGroup : '=alreadyBelongGroup'
        },
        link: function(scope, element, attrs) { 
            scope.$watch('userBelong', function() {
                if(typeof scope.userBelong != 'undefined'){
                    scope.answer = false;
                    if(scope.userBelong.belong == false){               
                        scope.icon = "btn-primary"; 
                        scope.text = "Rejoindre"; 
                    }else{
                        if(scope.userBelong.accepted == true){
                            scope.icon = "btn-default"; 
                            scope.text = "Se déinscrire";
                        }else{
                            scope.icon = "btn-default"; 
                            scope.text = "En attente de confirmation"; 
                        }
                    }
                }
            }, true);
            scope.belongGroup = function(){
                if (scope.userBelong.data && (scope.group.user.id == scope.userBelong.data.user.id)) {
                    $rootScope.flashMessage = {type: 'alert-warning', message: 'You can\'t leave your own group!'};
                }else{
                    if(scope.userBelong.belong == false){             
                        Group.belong({id: scope.userBelong.groupId},{}, function(belong){
                            scope.userBelong.belong = true;
                            if(scope.userBelong.private == false){
                                scope.userBelong.accepted = true;
                                scope.group.accepted_user_belongs.push(belong.data);
                                scope.userBelong.data = belong.data;
                            }
                            $rootScope.flashMessage = {type: belong.alert, message: belong.message};
                        });
                    }else{
                        if(scope.userBelong.accepted == true){
                            Group.unbelong({id: scope.userBelong.groupId, id_belong: scope.userBelong.data.id},{}, function(unbelong){
                                var index = scope.group.accepted_user_belongs.indexOf(scope.userBelong);
                                scope.group.accepted_user_belongs.splice(index, 1);
                                scope.userBelong.belong = false;
                                scope.userBelong.accepted = false;
                                $rootScope.flashMessage = {type: unbelong.alert, message: unbelong.message};
                            });
                        }else{
                            return;
                        }
                    }
                }
            }
        },
        template: '<button ng-cloack ng-click="belongGroup()" type="button" class="btn {{icon}}">{{text}}</button>'
    };
});

ObjectiveApp.directive('allowFriendUser', function(User, $rootScope, $http) {
    return {
        restrict: 'E',
        scope: {
            isFriend : '=isFriend',
            user: '=user',
            // userLogged : '=userLogged'
        },
        link: function(scope, element, attrs) { 
            scope.$watch('isFriend', function() {
                if(typeof scope.isFriend != 'undefined'){
                    scope.answer = false;
                    if(scope.isFriend.isFriend == false){               
                        scope.icon = "btn-primary"; 
                        scope.text = "Ajouter"; 
                    }else{
                        if(scope.isFriend.accepted == true){
                            scope.icon = "btn-default"; 
                            scope.text = "Retirer de la liste";
                        }else{
                            if(scope.isFriend.asked == true){
                                scope.icon = "btn-default"; 
                                scope.text = "En attente de confirmation"; 
                            }else{
                                scope.answer = true;
                            }
                        }
                    }
                }
            }, true);
            scope.friendUser = function(action){
                // var user = scope.user;
                if(scope.isFriend.isFriend == false){             
                    User.friend({id: scope.isFriend.userId},{}, function(){
                        scope.isFriend.asked = true; 
                        scope.isFriend.isFriend = true;
                    });
                }else{
                    if(scope.isFriend.accepted == true){
                        User.unfriend({id: scope.isFriend.userId, id_friend: scope.isFriend.data.id},{}, function(){
                            // var index = scope.user.friends.indexOf(scope.isFriend);
                            // scope.user.friends.splice(index, 1);
                            scope.isFriend.isFriend = false;
                            scope.isFriend.asked = false;
                            scope.isFriend.accepted = false;
                        });
                    }else{
                        if(scope.isFriend.asked == true){
                            return;
                        }else{
                            var friendUpdate = scope.isFriend.data;
                            friendUpdate.accepted = action;
                            if(action == true){
                                User.friendUpdate({id: scope.isFriend.userId, id_friend: scope.isFriend.data.id}, friendUpdate, function(friend){ 
                                    scope.isFriend.accepted = true; 
                                    //Maybe do that later differently to get the exact same object. I could use friends window like a widget
                                    // scope.user.friends.push(friend);
                                });
                            } else {
                                User.unfriend({id: scope.isFriend.userId, id_friend: scope.isFriend.data.id}, {}, function(){ 
                                    scope.isFriend.isFriend = false;
                                    scope.isFriend.asked = false;
                                });
                            }
                            scope.answer = false;
                        }
                    }
                }
            }
        },
        template: 
                '<span ng-cloack ng-if="isFriend.able != false">'+
                    '<span ng-if="answer == false">'+
                        '<button ng-click="friendUser()" type="button" class="btn {{icon}}">{{text}}</button>'+
                    '</span>'+
                    '<span ng-if="answer == true">'+
                        '<button ng-click="friendUser(true)" type="button" class="btn btn-primary">Accepter</button><button ng-click="friendUser(false)" type="button" class="btn btn-default">Refuser</button>'+
                    '</span>'+
                '</span>'
    };
});

ObjectiveApp.directive('manageMemberGroup', function(Group, $rootScope) {
    return {
        restrict: 'E',
        scope: {
            member : '=member',
            group : '=group'
        },
        link: function(scope, element, attrs) { 
            scope.manageMember = function(action){
                if(action == true){
                    var memberUpdate = scope.member;   
                    memberUpdate.accepted = action;       
                    Group.belongUpdate({id: scope.group.id, id_belong: scope.member.id}, memberUpdate , function(){});
                }else{
                    Group.unbelong({id: scope.group.id, id_belong: scope.member.id},{}, function(unbelong){
                        var index = scope.group.userbelonggroups.indexOf(unbelong);
                        scope.group.userbelonggroups.splice(index, 1);
                    });
                }
            }
        },
        template: 
                '<span ng-if="member.accepted == true">'+
                    '<button ng-click="manageMember()" type="button" class="btn btn-default">Retirer du groupe</button>'+
                '</span>'+
                '<span ng-if="member.accepted == false">'+
                    '<button ng-click="manageMember(true)" type="button" class="btn btn-primary">Accepter</button><button ng-click="manageMember(false)" type="button" class="btn btn-default">Refuser</button>'+
                '</span>'
    };
});

ObjectiveApp.directive("checkboxCategories", function () {
    return {
        restrict: "A",
        link: function (scope, elem, attrs) {
            if (scope.search.objective.category.indexOf(scope.category.key) !== -1) {
                elem[0].checked = true;
            }

            elem.bind('click', function () {
                var index = scope.search.objective.category.indexOf(scope.category.key);
                if (elem[0].checked) {
                    if (index === -1) scope.search.objective.category.push(scope.category.key);
                }
                else {
                    if (index !== -1) scope.search.objective.category.splice(index, 1);
                }
                scope.$apply(scope.search.objective.category.sort(function (a, b) {
                    return a - b;
                }));
            });
        }
    }
});