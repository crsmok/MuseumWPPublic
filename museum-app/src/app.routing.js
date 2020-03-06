"use strict";

appRouting.$inject = ["$urlRouterProvider", "$stateProvider"];

function appRouting($urlRouterProvider, $stateProvider) {
  $urlRouterProvider.otherwise("/login");
  $stateProvider.state('loginModule', {url: '/login'});
  //$urlRouterProvider.interceptors.push()
}

export { appRouting };
