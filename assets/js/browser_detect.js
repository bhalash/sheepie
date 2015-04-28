/**
 * Ghetto Browser Detection
 * -----------------------------------------------------------------------------
 * Now with 100% less jQuery! \o/
 * Please don't use this to disable features on your page; my own goal for 
 * it stems from needing to tweak layout because of browser quirks.
 * 
 * This is not a canonical list of every browser and OS; I tend to add to 
 * this as required.
 *
 * @category   JavaScript File
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  2014-2015 Mark Grealish
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @version    2.0
 * @link       https://github.com/bhalash/sheepie
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

(function() {
    'use strict';

    var agent = navigator.userAgent.toLowerCase();
    var html = document.getElementsByTagName('html')[0];

    if (/android|webos|iphone|ipod|blackberry|iemobile|opera mini/i.test(agent)) {
        // Any handheld device.
        html.classList.add('mobile');
    }

    /**
     * iOS and iOS Versions
     * --------------------
     * There are quirks related to flexbox and the vh unit in older versions of
     * iOS.
     */

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

    if (!!agent.match(/i(pad|phone|pod)/i)) {
        // iOS
        html.classList.add('ios');
    }

    /**
     * Desktop Operating Systems
     * -------------------------
     */

    if (/windows\snt/.test(agent)) {
        // Microsoft Windows
        html.classList.add('windows');
    }

    if (/linux/.test(agent)) {
        // Linux 
        html.classList.add('linux');
    }

    if (/os\sx/.test(agent) || /macintosh/.test(agent)) {
        // OS X
        html.classList.add('osx');
    }

    /**
     * Browsers
     * --------
     */

    if (/webkit/.test(agent)) {
        // General Webkit 
        html.classList.add('webkit');
    }

    if (/chrome/.test(agent)) {
        // Google Chrome
        html.classList.add('chrome');
    }

    if (/firefox/.test(agent)) {
        // Mozilla Firefox
        html.classList.add('firefox');
    }

    if (/MSIE\s([0-9]{1,}[\.0-9]{0,})/.test(agent) || /trident/.test(agent)) {
        // Microsoft Internet Explorer
        html.classList.add('ie');
    }

    if (/safari/.test(agent)) {
        // Apple Safari
        html.classList.add('safari');
    }
})();