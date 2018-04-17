class CandidatesRoutes {
    constructor($stateProvider) {
        $stateProvider.state('candidates', {
            name: 'candidates',
            url: '/candidates',
            views: {
                'content': {
                    template: require('./candidates.pug'),
                    controller: 'CandidatesCtrl',
                    controllerAs: '$candidatesCtrl'
                }
            }
        });
    }

    static routesFactory($stateProvider) {
        CandidatesRoutes.instance = new CandidatesRoutes($stateProvider);
        return CandidatesRoutes.instance;
    }
}

CandidatesRoutes.routesFactory.$inject = ['$stateProvider'];

export default CandidatesRoutes;