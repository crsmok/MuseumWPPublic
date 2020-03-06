"use strict";

referencesRouting.$inject = ["$urlRouterProvider", "$stateProvider"];

function referencesRouting($urlRouterProvider, $stateProvider) {
  $urlRouterProvider.otherwise("/login");

  $stateProvider.state(
    {
      name: "references",
      url: "/references",
      component: "referencesComponent",
      resolve: {
        'data' : ['ReferencesService',()=>{
            return 'test';
        }]
      },
      lazyLoad: ($transition$) => {
        const $ocLazyLoad = $transition$.injector().get("$ocLazyLoad");

        return import("./references.components")
          .then(mod => $ocLazyLoad.load(mod.REFERENCES_INDEX_MODULE))
          .catch(err => {
            throw new Error("Ooops, something went wrong, " + err);
          });
      }

    });
}

export { referencesRouting };
