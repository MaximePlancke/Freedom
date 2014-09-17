var ObjectiveApp = angular.module('ObjectiveApp', ['ngResource']);

var pathArray = window.location.pathname.split( '/' );

ObjectiveApp.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
}
);
