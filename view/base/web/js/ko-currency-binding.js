/*
 * Copyright © Ihor Oleksiienko (https://github.com/torys877)
 * See LICENSE for license details.
 */

define([
    "jquery",
    "ko",
    "uiComponent"
], function($, ko, Component) {
    "use strict";

    ko.bindingHandlers.currency = {
       init: function(element, valueAccessor) {
           element.innerHTML = valueAccessor();
       }
    };

});
