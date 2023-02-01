const $ = require('jquery');
global.$ = global.jQuery = $;

import './styles/app.css';
import './bootstrap';

require('@tabler/core/dist/css/tabler.min.css');
require('@tabler/core/dist/js/tabler.min');

// bootstrap must be after tabler in the load order
require('bootstrap/dist/js/bootstrap.bundle.min');
require('bootstrap/dist/css/bootstrap.min.css');

require('./components/register');
require('./components/form-map');
