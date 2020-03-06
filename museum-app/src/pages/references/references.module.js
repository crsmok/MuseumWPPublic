"use strict";

import angular from "angular";
import { referencesRouting } from "./references.routing";

const REFERENCES_MODULE = angular
  .module("referencesModule", [])
  .config(referencesRouting);
export { REFERENCES_MODULE };