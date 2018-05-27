window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

window.$ = window.jQuery = require('jquery');
window.Popper = require('popper.js');
require('bootstrap');

require('mediaelement');
require('@fancyapps/fancybox');
require('raty-js/lib/jquery.raty');
window.toastr = require('toastr');

import fontawesome from '@fortawesome/fontawesome';
import solid from '@fortawesome/fontawesome-free-solid';
import brands from '@fortawesome/fontawesome-free-brands';
import regular from '@fortawesome/fontawesome-free-regular';

fontawesome.library.add(solid, brands, regular);

window.axios = require('axios');
