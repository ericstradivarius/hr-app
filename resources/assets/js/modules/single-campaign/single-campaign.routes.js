class singleCampaignRoute {
    constructor($stateProvider) {
        $stateProvider.state('single-campaign', {
            name: 'campaign',
            url: '/campaigns/{id: [0-9]{1,8}}',
            views: {
                'content': {
                    template: require('./single-campaign.pug'),
                    controller: 'singleCampaignCtrl',
                    controllerAs: '$singleCampaignCtrl'
                }
            }
        });
    }

    static routesFactory($stateProvider) {
        singleCampaignRoute.instance = new singleCampaignRoute($stateProvider);
        return singleCampaignRoute.instance;
    }
}

singleCampaignRoute.routesFactory.$inject = ['$stateProvider'];

export default singleCampaignRoute;