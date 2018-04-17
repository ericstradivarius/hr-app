let leftMenuModule = angular.module('app.left-menu', []);

import leftMenuCtrl from './left-menu.controller';
leftMenuModule.controller('leftMenuCtrl', leftMenuCtrl);

import leftMenuDirective from './left-menu.directive';
leftMenuModule.directive('leftMenuDirective', () => new leftMenuDirective);

export default leftMenuModule;