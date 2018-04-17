class CampaignsRoutes {
    constructor($stateProvider) {
        $stateProvider.state('campaigns', {
            name: 'test',
            url: '/campaigns',
            views: {
                'content': {
                    template: require('./campaigns.pug'),
                    controller: 'CampaignsCtrl',
                    controllerAs: '$campaignsCtrl',
                }
            }
        });
    }

    static routesFactory($stateProvider) {
        CampaignsRoutes.instance = new CampaignsRoutes($stateProvider);
        return CampaignsRoutes.instance;
    }
}

CampaignsRoutes.routesFactory.$inject = ['$stateProvider'];



export default CampaignsRoutes;