/**
 * Created by Pongpan on 14-Jun-17.
 */
var app = angular.module('myApp', ['angularUtils.directives.dirPagination'], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});