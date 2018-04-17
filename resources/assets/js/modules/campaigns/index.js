let campaignsModule = angular.module('app.campaigns', []);

import CompRoutes from './campaigns.routes';
campaignsModule.config(CompRoutes.routesFactory);

import CampaignsCtrl from './campaigns.controller';
campaignsModule.controller('CampaignsCtrl', CampaignsCtrl);

import CampaignsFilter from './campaigns.filter';
campaignsModule.filter('dateToISO', CampaignsFilter);

import CampaignsService from './campaigns.service';
campaignsModule.factory('CampaignsService', CampaignsService);

export default campaignsModule;