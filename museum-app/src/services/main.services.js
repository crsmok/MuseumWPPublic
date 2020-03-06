import angular from "angular";
import {LoginService} from "./login.service";
import {ReferencesService} from "./references.service";
import {NetworkService} from "./network.service";

const REGISTER_SERVICE = angular
  .module("registerServices", [])
  .service("ReferencesService", ReferencesService)
  .service("NetworkService", NetworkService)
  .service("LoginService", LoginService);

export {REGISTER_SERVICE};