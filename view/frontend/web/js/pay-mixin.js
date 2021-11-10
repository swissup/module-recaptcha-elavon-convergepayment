define([
    'jquery',
    'mage/utils/wrapper'
], function ($, wrapper) {
    'use strict';

    return function (component) {
        component.pay = wrapper.wrap(component.pay, function () {
            var args = Array.prototype.slice.call(arguments),
                originalMethod = args.shift(args);

            debugger;

            return originalMethod.apply(this, args);
        });

        return component;
    }
});
