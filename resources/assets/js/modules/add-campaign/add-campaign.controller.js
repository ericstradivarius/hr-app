class addCampaignCtrl {

    constructor($http, headerService) {

        this.$http = $http;
        this.headerService = headerService;
        // Reset fields
        this.addCampaignName = '';
        this.start_date = '';
        this.end_date = '';
        this.select_result = '';
        this.available_jobs = '';
        this.description = '';
        this.addCampaignErrors = '';

    }

    sendCampaign() {
        const self = this;
        self.$http({
            method: 'post',
            url: '/campaigns',
            headers: {
                "accept": "application/json",
            },
            data: {
                "name": self.addCampaignName,
                "start_date": self.start_date ? self.start_date.format('YYYY-MM-DD') : '',
                "end_date": self.end_date ? self.end_date.format('YYYY-MM-DD') : '',
                "status": self.select_result,
                "available_jobs": self.available_jobs,
                "description": self.description
            }
        }).then(
            function () {
                confirm("Your campaign has been added succesfuly!");

                // Reset fields
                self.addCampaignName = '';
                self.start_date = '';
                self.end_date = '';
                self.select_result = '';
                self.available_jobs = '';
                self.description = '';
            },
            function (error) {
                self.addCampaignErrors = error.data.errors;
            }
        )
    };
}

addCampaignCtrl.$inject = ['$http','headerService'];
export default addCampaignCtrl;
