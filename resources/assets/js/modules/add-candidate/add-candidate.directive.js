import addCandidateCtrl from './add-candidate.controller';

class addCandidateDirective {
    constructor() {
        this.restrict = 'E';
        this.template = require('./add-candidate.pug');
        this.controller = addCandidateCtrl;
        this.controllerAs = "$addCandidateCtrl";
    }
}

export default addCandidateDirective;