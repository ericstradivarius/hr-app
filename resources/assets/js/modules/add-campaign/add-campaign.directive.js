import addCampaignCtrl from './add-campaign.controller';

class addCampaignDirective {
    constructor() {
        this.restrict = 'E';
        this.template = require('./add-campaign.pug');
        this.controller = addCampaignCtrl;
        this.controllerAs = "$addCampaignCtrl";

    }
}

export default addCampaignDirective;