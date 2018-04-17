function CampaignsFilter() {
    return function(input) {
        return moment(input).toISOString();
    };
}

export default CampaignsFilter;