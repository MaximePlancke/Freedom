ObjectiveApp.factory('Objective', ['$resource', function($resource){
    return $resource('/api/objectives/:id', { id: '@id'}, {
        delete: {method:'DELETE', params:{}},
        query: {method: 'GET', params:{}},
        queries: {method: 'GET', params:{}, isArray:true, url: '/api/objectives/:id'},
        update: {method: 'PUT', params:{}},
        like: {method: 'POST', url: '/api/objectives/:id/userlikeobjectives', params:{}},
        dislike: {method: 'DELETE', url: '/api/objectives/:id/userlikeobjectives/:id_like', params:{}},
        follow: {method: 'POST', url: '/api/objectives/:id/userfollowobjectives', params:{}},
        disfollow: {method: 'DELETE', url: '/api/objectives/:id/userfollowobjectives/:id_follow', params:{}},
    });
}]);

ObjectiveApp.factory('User', ['$resource', function($resource){
    return $resource('/api/users/:id', { id: '@id'}, {
        // delete: {method:'DELETE', params:{}},
        query: {method: 'GET', params:{}},
        queries: {method: 'GET', params:{}, isArray:true},
        // update: {method: 'PUT', params:{}},
        me: {method: 'GET', url: '/api/user/me', params:{}},
        followedObjective: {method: 'GET', url: '/api/users/:id/userfollowobjectives', params:{}, isArray:true},
        belongGroup: {method: 'GET', url: '/api/users/:id/userbelonggroups', params:{}, isArray:true},
        friend: {method: 'POST', url: '/api/users/:id/userfriendusers', params:{}},
        unfriend: {method: 'DELETE', url: '/api/users/:id/userfriendusers/:id_friend', params:{}},
        friendUpdate: {method: 'PUT', url: '/api/users/:id/userfriendusers/:id_friend', params:{}},
        isFriend: {method: 'GET', url: '/api/users/:id/isfriends/:id_friend', params:{}}
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

ObjectiveApp.factory('Userfollowobjective', ['$resource', function($resource){
    return $resource('/api/userfollowobjectives/:id', { id: '@id'}, {
        // delete: {method:'DELETE', params:{}},
        // query: {method: 'GET', params:{}},
        queries: {method: 'GET', params:{}, isArray:true},
        // update: {method: 'PUT', params:{}},
    });
}]);

ObjectiveApp.factory('Group', ['$resource', function($resource){
    return $resource('/api/groups/:id', { id: '@id'}, {
        query: {method: 'GET', params:{}},
        queries: {method: 'GET', params:{}, isArray:true},
        belong: {method: 'POST', url: '/api/groups/:id/userbelonggroups', params:{}},
        unbelong: {method: 'DELETE', url: '/api/groups/:id/userbelonggroups/:id_belong', params:{}},
        userBelong: {method: 'GET', url: '/api/groups/:id/userbelonggroups/:id_user', params:{}},
        belongUpdate: {method: 'PUT', url: '/api/groups/:id/userbelonggroups/:id_belong', params:{}},
        delete: {method:'DELETE',params:{}},
    });
}]);

ObjectiveApp.factory('modelService', [ function(){
    return {
        // ******** General Model ******** //
        types: function() {
            var types = [{ 
                key: 'objectives',
                value: 'Objectives/Experiences',
                url: 'public/html/objectiveSearchTemplate.html'
            },{ 
                key: 'users',
                value: 'Users', 
                url: 'public/html/userSearchTemplate.html'
            },{ 
                key: 'groups',
                value: 'Groups', 
                url: 'public/html/groupSearchTemplate.html'
            }];
            return types;
        },
        sortTypes: function() {
            var sortTypes = [{ 
                key: 'DESC'
            },{ 
                key: 'ASC'
            }];
            return sortTypes;
        },
        // ******** Objective Model ******** //
        listCategories: function() {
            var listCategories = [{
                key: "personnel",
                value: "Personnel",
            }, {
                key: "sportif",
                value: "Sportif",
            }, {
                key: "professionnel",
                value: "Professionnel"
            }, {
                key: "fun",
                value: "Fun"
            }];
            return listCategories;
        },
        doneTypes: function() {
            var doneTypes = [{ 
                key: '', 
                value: 'All'
            },{ 
                key: false, 
                value: 'Current'
            },{ 
                key: true, 
                value: 'Done'
            }];
            return doneTypes;
        },
        objectiveOrderBy: function() {
            var objectiveOrderBy = [{ 
                key: 'Creation Date',
                value: 'datecreation'
            },{ 
                key: 'Goal Date',
                value: 'dategoal'
            }];
            return objectiveOrderBy;
        }
    };

}]);




