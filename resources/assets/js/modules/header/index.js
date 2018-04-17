let headerModule = angular.module('app.header', []);

import headerCtrl from './header.controller';
headerModule.controller('headerCtrl', headerCtrl);

import headerDirective from './header.directive';
headerModule.directive('headerDirective', () => new headerDirective);

import headerService from './header.service';
headerModule.factory('headerService', headerService);

export default headerModule;