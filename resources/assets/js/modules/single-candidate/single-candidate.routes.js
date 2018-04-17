class singleCandidate {
    constructor($stateProvider) {
        $stateProvider.state('single-candidate', {
            name: 'candidate',
            url: '/candidates/{id: [0-9]{1,8}}',
            views: {
                'content': {
                    template: require('./single-candidate.pug'),
                    controller: 'singleCandidateCtrl',
                    controllerAs: '$singleCandidateCtrl',
                }
            }
        });

    }

    static routesFactory($stateProvider) {
        singleCandidate.instance = new singleCandidate($stateProvider);
        return singleCandidate.instance;
    }
}

singleCandidate.routesFactory.$inject = ['$stateProvider'];

export default singleCandidate;