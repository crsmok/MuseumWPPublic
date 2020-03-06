// bootstrap.js

"use strict";

import angular from "angular";
import { MUS_APP } from "../app";

angular.bootstrap(document, [MUS_APP.name], {
  strictDi: true
});
