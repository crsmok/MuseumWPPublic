"use strict";

maindeskRouting.$inject = ["$urlRouterProvider", "$stateProvider"];

function maindeskRouting($urlRouterProvider, $stateProvider) {
  $urlRouterProvider.otherwise("/login");

  $stateProvider.state(
    {
      name: "maindesk",
      url: "/maindesk",
      component: "maindeskComponent",
      lazyLoad: ($transition$) => {
        const $ocLazyLoad = $transition$.injector().get("$ocLazyLoad");

        return import("./maindesk.components")
          .then(mod => $ocLazyLoad.load(mod.MAINDESK_INDEX_MODULE))
          .catch(err => {
            throw new Error("Ooops, something went wrong, " + err);
          });
      }

    });
}

export { maindeskRouting };
