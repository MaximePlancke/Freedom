var ObjectiveApp = angular.module('ObjectiveApp', ['ngResource', 'ngAnimate', 'ngSanitize']);

ObjectiveApp.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
}
);

ObjectiveApp.run(function($rootScope) {
	$rootScope.url = function(route, params){
	    var url = Routing.generate(route, params, true);
	    window.location.href= url;
	}
})

var pathArray = window.location.pathname.split( '/' );
