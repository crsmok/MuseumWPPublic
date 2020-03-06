"use strict";

import angular from "angular";
import ReferencesController from "./references.controller";

class ReferencesComponent {
  constructor() {
    this.template = require("./references.view.html");
    this.controller = ReferencesController;
  }
}

const REFERENCES_INDEX_MODULE = angular
  .module("references.module", [])
  .component("referencesComponent", new ReferencesComponent());

export { REFERENCES_INDEX_MODULE };
