import leftMenuCtrl from './left-menu.controller';

class leftMenuDirective {
    constructor() {
        this.restrict = 'E';
        this.template = require('./left-menu.pug');
        this.controller = leftMenuCtrl;
        this.controllerAs = "$leftMenuCtrl";
    }
}

export default leftMenuDirective;