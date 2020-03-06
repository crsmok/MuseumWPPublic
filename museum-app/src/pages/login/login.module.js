"use strict";

import angular from "angular";
import { loginRouting } from "./login.routing";

const LOGIN_MODULE = angular
  .module("loginModule", [])
  .config(loginRouting);

export { LOGIN_MODULE };