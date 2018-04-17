class CampaignsCtrl {
    constructor($http) {

        this.campaignAndCandidates = [];
        this.campaignNumber = 0;
        this.campainNumberOfPages = [];
        this.perPage = 4;
        this.$http = $http;
        this.numberOfCampaigns();

        //sort init
        this.propertyName = 'status';
        this.sortBy = 'desc';
        //endOf sort init

        this.pageNumber = 1;

        this.showCampaigns(this.pageNumber, this.propertyName);
        this.addCampaignErrors=[];

    }


    numberOfCampaigns () {
        const self = this;
        this.$http({
            method: 'get',
            url: '/campaigns/count',
            headers: {
                "accept": "application/json",
            }
        }).then(
            function (response) {
                self.campainNumberOfPages = new Array(Math.ceil(response.data.data.count / self.perPage));
            }
        )
    };

    showCampaigns (pageNumber, propertyName) {
        const self = this;
        self.propertyName = propertyName;

        if(pageNumber === self.pageNumber) {
            self.sortBy = (self.sortBy === 'asc') ? 'desc' : 'asc';
        }

        self.pageNumber = pageNumber;

        this.$http({
            method: 'get',
            url: '/campaigns?with[]=candidates',
            headers: {
                "accept": "application/json",
            },
            params: {
                'per_page': this.perPage,
                'order_by_type[]': [self.sortBy, 'asc'],
                'order_by_column[]': [self.propertyName, 'start_date'],
                'page': pageNumber
            }
        }).then(
            function (response) {

                self.campaignAndCandidates = [];
                self.campaignAndCandidates = response.data.data.data;

            },
            function (error) {
                this.errors = error.data.errors;
            }
        )
    };




    openSingleCampaign(campaignId) {
        const self = this;
        this.$http({
            method: 'get',
            url: '/campaigns/'+campaignId,
            headers: {
                "accept": "application/json",
            }
        }).then(
             function (response) {
                 self.thisCampaignArray = response.data.data;
               
             },
             function (error) {
                 self.errors = error.data.errors;
             }
        )
    };

}

CampaignsCtrl.$inject = ['$http'];
export default CampaignsCtrl;