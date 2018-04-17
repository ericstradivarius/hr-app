function CampaignsService() {
    let obj = {};
    obj.dateFilter = function(input) {
        //console.log(input);
        return new Date(input).toISOString();
    };
    return obj;
}

export default CampaignsService;
