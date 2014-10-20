ObjectiveApp.controller('ObjectiveCurrentCtrl', [ '$rootScope', '$scope', 'Advice' , 'Objective', 'Step', '$filter', function ($rootScope, $scope, Advice, Objective, Step, $filter) {

    //Init
    $scope.objectives = [];

    Objective.queries({limit: 10, filters : {user: parseInt(pathArray[1]), done: 0}, order_by :{datecreation: 'DESC'}},{}, function(data){
        $scope.objectives = data;

    });

    $scope.deleteObjective = function(idx){
        var objective = $scope.objectives[idx];
        Objective.delete({id: objective.id},{});
        $scope.objectives.splice(idx,1);
        $rootScope.flashMessage = {type: 'alert-success', message: 'Objective removed !'};
    }

    $scope.doneObjective = function(idx){
        var objective = $scope.objectives[idx];
        objective.done = !objective.done;
        var now = $filter('date')(new Date(), 'yyyy/MM/dd HH:mm:ss');
        objective.datedone = now;
        Objective.update({id: objective.id}, objective);
        $scope.objectives.splice(idx,1);
        $rootScope.flashMessage = {type: 'alert-success', message: 'Your post has been moved !'};
    }

    $scope.deleteStep = function(idx, idxObj){
        var step = $scope.objectives[idxObj].steps[idx];
        Step.delete({id: $scope.objectives[idxObj].id, id_step: step.id},{});
        $scope.objectives[idxObj].steps.splice(idx,1);

    }

    $scope.doneStep = function(idx, idxObj){
        var step = $scope.objectives[idxObj].steps[idx];
        step.done = !step.done;
        $scope.objectives[idxObj].steps[idx] = Step.update({id: $scope.objectives[idxObj].id , id_step: step.id},step);
    }

    $scope.deleteAdvice = function(idx, idxObj){
        var advice = $scope.objectives[idxObj].advices[idx];
        Advice.delete({id: $scope.objectives[idxObj].id, id_advice: advice.id},{});
        $scope.objectives[idxObj].advices.splice(idx,1);
    }

}]);

ObjectiveApp.controller('ObjectiveDoneCtrl', [ '$rootScope', '$scope', 'Advice' , 'Objective', 'Step', '$filter', function ($rootScope, $scope, Advice, Objective, Step, $filter) {

    //Init
    $scope.objectives = [];
    Objective.queries({limit: 10, filters : {user: parseInt(pathArray[1]), done: 1}, order_by :{datedone: 'DESC'}},{}, function(data){
        $scope.objectives = data;
    });

    $scope.deleteObjective = function(idx){
        var objective = $scope.objectives[idx];
        Objective.delete({id: objective.id},{});
        $scope.objectives.splice(idx,1);
        $rootScope.flashMessage = {type: 'alert-success', message: 'Objective removed !'};
    }

    $scope.doneObjective = function(idx){
        var objective = $scope.objectives[idx];
        objective.done = !objective.done;
        var now = $filter('date')(new Date(), 'yyyy/MM/dd HH:mm:ss');
        objective.datedone = now;
        Objective.update({id: objective.id}, objective);
        $scope.objectives.splice(idx,1);
        $rootScope.flashMessage = {type: 'alert-success', message: 'Your post has been moved !'};
    }

    $scope.deleteStep = function(idx, idxObj){
        var step = $scope.objectives[idxObj].steps[idx];
        Step.delete({id: $scope.objectives[idxObj].id, id_step: step.id},{});
        $scope.objectives[idxObj].steps.splice(idx,1);

    }

    $scope.doneStep = function(idx, idxObj){
        var step = $scope.objectives[idxObj].steps[idx];
        step.done = !step.done;
        $scope.objectives[idxObj].steps[idx] = Step.update({id: $scope.objectives[idxObj].id , id_step: step.id},step);
    }

    $scope.deleteAdvice = function(idx, idxObj){
        var advice = $scope.objectives[idxObj].advices[idx];
        Advice.delete({id: $scope.objectives[idxObj].id, id_advice: advice.id},{});
        $scope.objectives[idxObj].advices.splice(idx,1);
    }

}]);

ObjectiveApp.controller('ObjectiveDetailsCtrl', [ '$scope', 'Advice' , 'Objective', 'Step', '$filter', function ($scope, Advice, Objective, Step, $filter) {

    //Init
    $scope.objective = {};

    Objective.query({id: parseInt(pathArray[2])},{}, function(data){
        $scope.objective = data;
        // console.log(data);
    });

    $scope.deleteObjective = function(id){
        Objective.delete({id: id},{});
        document.location.href="/";
    }

    $scope.doneObjective = function(id){
        var objective = $scope.objective;
        objective.done = !objective.done;
        var now = $filter('date')(new Date(), 'yyyy/MM/dd HH:mm:ss');
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

    $scope.deleteAdvice = function(idx){
        var advice = $scope.objective.advices[idx];
        Advice.delete({id: $scope.objective.id, id_advice: advice.id},{});
        $scope.objective.advices.splice(idx,1);
    }

}]);

ObjectiveApp.controller('ObjectiveFollowedCtrl', [ '$rootScope', '$scope' , 'Objective', 'Advice', 'Step', 'User', '$filter', function ($rootScope, $scope, Objective, Advice, Step, User, $filter) {

    //Init
    $scope.objectives = [];
    User.followedObjective({limit: 10, id: parseInt(pathArray[1]) , filters : {}},{}, function(data){
        $scope.objectives = data;
    });

    $scope.deleteObjective = function(idx){
        var objective = $scope.objectives[idx];
        Objective.delete({id: objective.id},{});
        $scope.objectives.splice(idx,1);
        $rootScope.flashMessage = {type: 'alert-success', message: 'Objective removed !'};
    }

    $scope.doneObjective = function(idx){
        var objective = $scope.objectives[idx];
        objective.done = !objective.done;
        var now = $filter('date')(new Date(), 'yyyy/MM/dd HH:mm:ss');
        objective.datedone = now;
        Objective.update({id: objective.id}, objective);
    }

    $scope.deleteStep = function(idx, idxObj){
        var step = $scope.objectives[idxObj].steps[idx];
        Step.delete({id: $scope.objectives[idxObj].id, id_step: step.id},{});
        $scope.objectives[idxObj].steps.splice(idx,1);

    }

    $scope.doneStep = function(idx, idxObj){
        var step = $scope.objectives[idxObj].steps[idx];
        step.done = !step.done;
        $scope.objectives[idxObj].steps[idx] = Step.update({id: $scope.objectives[idxObj].id , id_step: step.id},step);
    }

    $scope.deleteAdvice = function(idx, idxObj){
        var advice = $scope.objectives[idxObj].advices[idx];
        Advice.delete({id: $scope.objectives[idxObj].id, id_advice: advice.id},{});
        $scope.objectives[idxObj].advices.splice(idx,1);
    }

}]);

ObjectiveApp.controller('ExploreSearchCtrl', [ '$scope', 'Objective', 'User', 'Group','$filter', 'modelService', function ($scope, Objective, User, Group, $filter, modelService) {

    //Get models from factories
    $scope.types = modelService.types();
    $scope.objectiveSort = modelService.sortTypes();
    //Get models for objectives
    $scope.listCategories = modelService.listCategories();
    $scope.doneTypes = modelService.doneTypes();
    $scope.objectiveOrderBy = modelService.objectiveOrderBy();

    //Init
    var timeOutID = 0;
    $scope.loading = false; 
    $scope.search = {};
    $scope.search.objective = {};
    $scope.search.orderBy = {};
    $scope.search.objective.category = [];
    $scope.search.orderBy.objective = {};
    //Init default search values
    $scope.search.offset = 0;
    $scope.search.limit = 15;
    $scope.search.name = '';
    $scope.search.type = $scope.types[0];
    //Init objective default search values
    $scope.search.objective.done = $scope.doneTypes[0].key;

    $scope.$watch('search', function(newValue, oldValue, scope) {
        var filters = {};
        $scope.loading = true;
        if(timeOutID !== 0) clearTimeout(timeOutID);
        timeOutID = setTimeout(function(){
            timeOutID = 0;
            if(newValue.type.key == 'objectives'){
                angular.forEach(newValue.objective, function(value, key) {
                    if(value.length != 0){
                        filters[key] = value;
                    }
                });
                Objective.queries({limit: newValue.limit, offset: newValue.offset, filters : filters, name : newValue.name, order_by : {datecreation: 'DESC'} },{}, function(data){
                    $scope.results = data;
                    $scope.loading = false;
                });
            } else if(newValue.type.key == 'users'){
                angular.forEach(newValue.user, function(value, key) {
                    if(value.length != 0){
                        filters[key] = value;
                    }
                });
                User.queries({limit: newValue.limit, offset: newValue.offset, filters : filters, name : newValue.name, order_by :{id: 'DESC'}},{}, function(data){
                    $scope.results = data;
                    $scope.loading = false;
                });
            } else if (newValue.type.key == 'groups'){
                angular.forEach(newValue.group, function(value, key) {
                    if(value.length != 0){
                        filters[key] = value;
                    }
                });
                Group.queries({limit: newValue.limit, offset: newValue.offset, filters : filters, name : newValue.name, order_by :{id: 'DESC'}},{}, function(data){
                    $scope.results = data;
                    $scope.loading = false;
                });
            }
        }, 250);
    }, true);

}]);

ObjectiveApp.controller('ProfileCtrl', [ '$scope', 'User', function ($scope, User) {

    //Init
    var profileUserId = parseInt(pathArray[1]);
    $scope.user = {};
    $scope.isFriend;

    User.query({id: profileUserId},{}, function(data){
        $scope.user = data;
        // console.log(data);
    });
    $scope.$watch('userLogged', function() {
        User.isFriend({id: profileUserId, id_friend: $scope.userLogged},{}, function(data){
            $scope.isFriend = data.isFriend;
        });
    });
}]);

ObjectiveApp.controller('GroupProfileCtrl', [ '$scope', 'User', function ($scope, User) {

    //Init
    $scope.groups = [];
    $scope.pathUser = parseInt(pathArray[1]);

    User.belongGroup({limit: 10, id: parseInt(pathArray[1]) , filters : {}},{}, function(data){
        $scope.groups = data;
        // console.log(data);
    });

}]);


ObjectiveApp.controller('GroupDetailsCtrl', [ '$scope', 'Group', function ($scope, Group) {

    //Init
    var groupId = parseInt(pathArray[2]);
    $scope.group = {};

    Group.query({id: groupId},{}, function(data){
        $scope.group = data;
    });
    $scope.$watch('userLogged', function() {
        Group.userBelong({id: groupId, id_user: $scope.userLogged},{}, function(data){
            $scope.userBelong = data.userBelong;
        });
    });

}]);






