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
        var now = $filter('date')(new Date(), 'yyyy/MM/dd hh:mm:ss');
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
        var now = $filter('date')(new Date(), 'yyyy/MM/dd hh:mm:ss');
        objective.datedone = now;
        Objective.update({id: objective.id}, objective);
        $scope.objectives[idx]
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
    $scope.objective = [];

    Objective.query({id: parseInt(pathArray[2])},{}, function(data){
        $scope.objective = data;
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

    $scope.deleteAdvice = function(idx){
        var advice = $scope.objective.advices[idx];
        Advice.delete({id: $scope.objective.id, id_advice: advice.id},{});
        $scope.objective.advices.splice(idx,1);
    }

}]);

ObjectiveApp.controller('ExploreSearchCtrl', [ '$scope', 'Objective', 'User' ,'$filter', 'modelService', function ($scope, Objective, User, $filter, modelService) {

    //Init
    $scope.loading = false;
    $scope.listCategories = modelService.listCategories();
    $scope.types = modelService.types();

    $scope.search = {};
    $scope.search.objective = {};
    $scope.search.name = '';
    $scope.search.objective.done = true;
    $scope.search.objective.category = [];
    $scope.search.type = $scope.types[0];

    $scope.$watch('search', function(newValue, oldValue, scope) {
        var filters = {};
        $scope.loading = true;
        if(newValue.type.name == 'objectives'){
            angular.forEach(newValue.objective, function(value, key) {
                if(value.length != 0){
                    filters[key] = value;
                }
            });
            Objective.queries({limit: 10, filters : filters, order_by :{datecreation: 'DESC'}},{}, function(data){
                $scope.results = data;
                $scope.loading = false;
            });
        } else if(newValue.type.name == 'users'){
            angular.forEach(newValue.user, function(value, key) {
                if(value.length != 0){
                    filters[key] = value;
                }
            });
            User.queries({limit: 10, filters : filters, order_by :{id: 'DESC'}},{}, function(data){
                $scope.results = data;
                $scope.loading = false;
            });
        }
    }, true);

}]);


