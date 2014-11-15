ObjectiveApp.controller('ObjectiveCurrentCtrl', ['$scope' , 'Objective', function ($scope, Objective) {

    //Init
    $scope.objectives = [];

    Objective.queries({limit: 10, filters : {user: parseInt(pathArray[1]), done: 0}, order_by :{datecreation: 'DESC'}},{}, function(data){
        $scope.objectives = data;
    });

}]);

ObjectiveApp.controller('ObjectiveDoneCtrl', [ '$scope', 'Objective', function ($scope, Objective) {

    //Init
    $scope.objectives = [];
    Objective.queries({limit: 10, filters : {user: parseInt(pathArray[1]), done: 1}, order_by :{datedone: 'DESC'}},{}, function(data){
        $scope.objectives = data;
    });

}]);

ObjectiveApp.controller('ObjectiveFollowedCtrl', [ '$scope' , 'User', function ($scope, User) {

    //Init
    $scope.objectives = [];
    User.followedObjective({limit: 10, id: parseInt(pathArray[1]) , filters : {}},{}, function(data){
        $scope.objectives = data;
    });

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
        Step.update({id: $scope.objective.id , id_step: step.id}, step , function(data){
            $scope.objective.steps[idx] = data;
        });
    }

    $scope.deleteAdvice = function(idx){
        var advice = $scope.objective.advices[idx];
        Advice.delete({id: $scope.objective.id, id_advice: advice.id},{});
        $scope.objective.advices.splice(idx,1);
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
            $scope.isFriend = data;
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

ObjectiveApp.controller('FriendProfileCtrl', [ '$scope', 'User', function ($scope, User) {

    //Init
    var profileUserId = parseInt(pathArray[1]);
    $scope.friends = [];

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
            // console.log(data);
            $scope.userBelong = data;
        });
    });

}]);

ObjectiveApp.controller('GroupDashboardCtrl', [ '$scope', 'User', 'Group', '$rootScope', function ($scope, User, Group, $rootScope) {

    //Init
    $scope.groups = [];

    $scope.$watch('userLogged', function() {
        if(typeof $scope.userLogged != 'undefined'){
            User.me({filters : {user: $scope.userLogged}, order_by :{id: 'DESC'}},{}, function(data){
                $scope.user = data;
                // console.log(data);
            });
        }
    });

    $scope.deleteGroup = function(idx){
        var group = $scope.user.owngroups[idx];
        Group.delete({id: group.id},{});
        $scope.user.owngroups.splice(idx,1);
        $rootScope.flashMessage = {type: 'alert-success', message: 'Group removed !'};
    }

}]);






