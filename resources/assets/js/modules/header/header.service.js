function headerService() {
    let obj = {};

    //Campaigns
    obj.triggerCampaignSet = function (input) {
        obj.campaign_input = input;
    };

    obj.triggerCampaignGet = function () {
        if(obj.campaign_input === undefined){
            obj.campaign_input = false;
        }
        return obj.campaign_input;
    };

    //Candidates
    obj.triggerCandidateSet = function(input) {
        obj.candidate_input = input;
    }

    obj.triggerCandidateGet = function () {
        if(obj.candidate_input === undefined){
            obj.candidate_input = false;
        }
        return obj.candidate_input;
    }

    return obj;
}

export default headerService;
