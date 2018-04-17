import headerCtrl from './header.controller';

class headerDirective {
    constructor() {
        this.restrict = 'E';
        this.template = require('./header.pug');
        this.controller = headerCtrl;
        this.controllerAs = "$headerCtrl";
    }
}

export default headerDirective;

