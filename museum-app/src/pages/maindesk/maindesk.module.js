"use strict";

import angular from "angular";
import { maindeskRouting } from "./maindesk.routing";

const MAINDESK_MODULE = angular
  .module("maindeskModule", [])
  .config(maindeskRouting);
export { MAINDESK_MODULE };