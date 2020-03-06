// app.js

"use strict";

import angular from "angular";
import "@uirouter/angularjs";
import "oclazyload";
import "bootstrap"
import 'angular-ui-router';
import './scss/app.scss';
import './services/main.services';
import 'angular-gettext';


import "./pages/login/login.module";
import "./pages/maindesk/maindesk.module";
import "./pages/references/references.module";
import { appRouting } from "./app.routing";

const MUS_APP =  angular
  .module("musApp", [
    "ui.router",
    "gettext",
    "oc.lazyLoad",
    "loginModule",
    "maindeskModule",
    "referencesModule",
    "registerServices"
  ])
  .config(appRouting);

export { MUS_APP };
