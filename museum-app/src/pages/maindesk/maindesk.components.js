"use strict";

import angular from "angular";
import MainDeskController from "./maindesk.controller";

class MaindeskComponent {
  constructor() {
    this.template = require("./maindesk.view.html");
    this.controller = MainDeskController;
  }
}

const MAINDESK_INDEX_MODULE = angular
  .module("maindesk.module", [])
  .component("maindeskComponent", new MaindeskComponent());

export { MAINDESK_INDEX_MODULE };
