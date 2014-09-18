var ObjectiveApp = angular.module('ObjectiveApp', ['ngResource']);

ObjectiveApp.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
}
);

var pathArray = window.location.pathname.split( '/' );
