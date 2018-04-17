let singleCampaign = angular.module('app.single-campaign', []);

import CompRoutes from './single-campaign.routes';
singleCampaign.config(CompRoutes.routesFactory);

import singleCampaignCtrl from './single-campaign.controller';
singleCampaign.controller('singleCampaignCtrl', singleCampaignCtrl);

export default singleCampaign;