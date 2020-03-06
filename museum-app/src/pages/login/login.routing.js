"use strict";

loginRouting.$inject = ["$urlRouterProvider", "$stateProvider"];

function loginRouting($urlRouterProvider, $stateProvider) {
  $urlRouterProvider.otherwise("/login");

  $stateProvider.state(
    {
      name: "login",
      url: "/login",
      component: "loginComponent",
      lazyLoad: ($transition$) => {
        const $ocLazyLoad = $transition$.injector().get("$ocLazyLoad");

        return import("./login.components")
          .then(mod => $ocLazyLoad.load(mod.LOGIN_INDEX_MODULE))
          .catch(err => {
            throw new Error("Ooops, something went wrong, " + err);
          });
      }
    });
}

export { loginRouting };
