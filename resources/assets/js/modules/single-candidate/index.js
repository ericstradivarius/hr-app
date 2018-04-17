let singleCandidate = angular.module('app.single-candidate', []);

import CompRoutes from './single-candidate.routes';
singleCandidate.config(CompRoutes.routesFactory);

import singleCandidateCtrl from './single-candidate.controller';
singleCandidate.controller('singleCandidateCtrl', singleCandidateCtrl);

export default singleCandidate;