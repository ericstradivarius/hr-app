let addCandidateModule = angular.module('app.add-candidate', []);

import addCandidateCtrl from './add-candidate.controller';
addCandidateModule.controller('addCandidateCtrl', addCandidateCtrl);

import addCandidateDirective from './add-candidate.directive';
addCandidateModule.directive('addCandidateDirective', () => new addCandidateDirective);

export default addCandidateModule;