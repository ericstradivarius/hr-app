require('./bootstrap');
import 'angular';
import "angular-moment-picker";
import "angular-sanitize";
import 'ng-file-upload';
import 'angular-ui-bootstrap';
import 'angular-route';

import '@uirouter/angularjs';
import appRoutes from './app.routes';

import './modules/campaigns';
import './modules/candidates';
import './modules/single-candidate';
import './modules/single-campaign';
import './modules/header';
import './modules/left-menu';
import './components/user';
import './modules/add-campaign';
import './modules/add-candidate';

let app = angular.module('app', [
    'ui.router',
    'app.left-menu',
    'app.header',
    'app.candidates',
    'app.campaigns',
    'app.add-campaign',
    'app.add-candidate',
    'app.single-candidate',
    'app.single-campaign',
    'app.userModule',
    'moment-picker',
    'ngSanitize',
    'ngFileUpload',
    'ui.bootstrap',
    'ngRoute'
]);

angular.module('app').config(appRoutes);