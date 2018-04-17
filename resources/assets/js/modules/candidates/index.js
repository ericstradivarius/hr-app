let candidatesModule = angular.module('app.candidates', []);

import CompRoutes from './candidates.routes';
candidatesModule.config(CompRoutes.routesFactory);

import CandidatesCtrl from './candidates.controller';
candidatesModule.controller('CandidatesCtrl', CandidatesCtrl);

import generateInitials from './candidates.directive';
candidatesModule.directive('generateInitials', () => new generateInitials);

export default candidatesModule;