let addCampaignModule = angular.module('app.add-campaign', []);

import addCampaignCtrl from './add-campaign.controller';
addCampaignModule.controller('addCampaignCtrl', addCampaignCtrl);

import addCampaignDirective from './add-campaign.directive';
addCampaignModule.directive('addCampaignDirective', () => new addCampaignDirective);

export default addCampaignModule;