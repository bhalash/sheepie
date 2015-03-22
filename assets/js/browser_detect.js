(function() {
    'use strict';
    /*
     * Ghetto Browser Detection
     * ------------------------
     * Now with 100% less jQuery! \o/
     */

    var agent = navigator.userAgent.toLowerCase();
    var html = document.getElementsByTagName('html')[0];

    if (/android|webos|iphone|ipod|blackberry|iemobile|opera mini/i.test(agent)) {
        // Any handheld device.
        html.classList.add('mobile');
    }

    if (!!agent.match(/i(pad|phone|pod).+(version\/6\.\d+ mobile)/i)) {
        // iOS 6
        html.classList.add('ios-6');
    }

    if (!!agent.match(/i(pad|phone|pod).+(version\/7\.\d+ mobile)/i)) {
        // iOS 7 
        html.classList.add('ios-7');
    }

    if (!!agent.match(/i(pad|phone|pod).+(version\/8\.\d+ mobile)/i)) {
        // iOS 8
        html.classList.add('ios-8');
    }

    if (/webkit/.test(agent)) {
        // Webkit 
        html.classList.add('webkit');
    }

    if (/trident/.test(agent)) {
        // Internet Explorer
        html.classList.add('internet-explorer');
    }

    if (/chrome/.test(agent)) {
        // Google Chrome
        html.classList.add('chrome');
    }

    if (/firefox/.test(agent)) {
        // Mozilla Firefox
        html.classList.add('firefox');
    }
})();