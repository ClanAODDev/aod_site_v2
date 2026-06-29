import _ from 'lodash';
import $ from 'jquery';
import 'jquery-migrate';
import axios from 'axios';

window._ = _;
window.$ = window.jQuery = $;

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
