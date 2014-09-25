ObjectiveApp.factory('Objective', ['$resource', function($resource){
    return $resource('/api/objectives/:id', { id: '@id'}, {
        delete: {method:'DELETE', params:{}},
        query: {method: 'GET', params:{}},
        queries: {method: 'GET', params:{}, isArray:true, url: '/api/objectives/:id'},
        update: {method: 'PUT', params:{}},
        like: {method: 'POST', url: '/api/objectives/:id/userlikeobjectives', params:{}},
        dislike: {method: 'DELETE', url: '/api/objectives/:id/userlikeobjectives/:id_like', params:{}}
    });
}]);

ObjectiveApp.factory('User', ['$resource', function($resource){
    return $resource('/api/users/:id', { id: '@id'}, {
        // delete: {method:'DELETE', params:{}},
        // query: {method: 'GET', params:{}},
        queries: {method: 'GET', params:{}, isArray:true},
        // update: {method: 'PUT', params:{}},
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


ObjectiveApp.factory('modelService', [ function(){
    return {
        listCategories: function() {
            var listCategories = [{
                "key": "personnel",
                "value": "Personnel",
            }, {
                "key": "sportif",
                "value": "Sportif",
            }, {
                "key": "professionnel",
                "value": "Professionnel"
            }, {
                "key": "fun",
                "value": "Fun"
            }];
            return listCategories;
        },
        types: function() {
            var types = [{ 
                name: 'objectives', 
                url: 'public/html/objectiveSearchTemplate.html'
            },{ 
                name: 'users', 
                url: 'public/html/userSearchTemplate.html'
            }];
            return types;
        }
    };

}]);



