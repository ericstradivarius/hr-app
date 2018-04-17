import CampaignsService from '../campaigns/campaigns.service';

class singleCampaignCtrl {

    constructor($http, $stateParams,$location, CampaignsService) {
        this.$http = $http;
        this.pageNumber = 1;
        this.pageNumbers = 0;
        this.currentPage = 1;

        this.getDataSingleCampaign($stateParams.id, $http);

        this.getCandidatesSingleCampaign($stateParams.id, this.currentPage);

        this.CampaignsService = CampaignsService;
        this.$location = $location;
    }

//Dates from specific campaign
    getDataSingleCampaign(campaignId, $http) {
        const self = this;
        this.$http({
            method: 'get',
            url: '/campaigns/' + campaignId,
            headers: {
                "accept": "application/json"
            },
            params: {
                'with[]': ['candidates']
            }
        }).then(
            function (response) {
                self.singleCampaignData = response.data.data;
            },
            function (error) {
                self.errors = error.data.errors;
            }
        )

    }


    getCandidatesSingleCampaign(campaignId, pageNumber) {
        const self = this;
        this.$http({
            method: 'get',
            url: '/campaigns-candidates',
            headers: {
                "accept": "application/json"
            },
            params: {
                'per_page': 5,
                'page': pageNumber,
                'id': campaignId
            }
        }).then(
            function (response) {
                self.singleCampaignCandidates = response.data.data.data;

                //console.log(self.singleCampaignCandidates);

                self.totalItems = response.data.data.page.totalItems;
                self.currentPage = response.data.data.pager.current;
                self.totalPages = Math.ceil(self.totalItems / 5); // 2
            },
            function (error) {
                self.errors = error.data.errors;
            }
        );


    }

    //Edit campaign controller
    editCampaignModal(campaign, campaignId) {
        const self = this;
        this.$http({
            method: 'put',
            url: '/campaigns/'+campaignId,
            headers: {
                "accept": "application/json"
            },
            data: {
                "name": campaign.name,
                "start_date": moment(campaign.start_date).format('YYYY-MM-DD'),
                "end_date": moment(campaign.end_date).format('YYYY-MM-DD'),
                "status": campaign.status,
                "available_jobs": campaign.available_jobs,
                "description": campaign.description
            }
        }).then(
            function (response) {
                $('#editCampaignModal').modal('hide');
                window.alert('Campaign has been updated!');
                self.headerSuccess=true;
                self.headerErrors=false;

            },
            function (error) {
                self.headerErrors = error.data.errors;
            });

    }


    // Delete single campaign
    deleteSingleCampaign(campaign, campaignId){
        const self = this;
        this.$http({
            url: '/campaigns/'+campaignId,
            method: "DELETE",
            headers: {
                "accept": "application/json"
            },
            data: {
                "name": campaign.name,
                "start_date": moment(campaign.start_date).format('YYYY-MM-DD'),
                "end_date": moment(campaign.end_date).format('YYYY-MM-DD'),
                "status": campaign.status,
                "available_jobs": campaign.available_jobs,
                "description": campaign.description
            }
        }).then(
            function (response) {
                $('#deleteMyCampaign').modal('hide');
                self.$location.path('/campaigns');
                self.$location.replace();
            }
        )
    }

}

singleCampaignCtrl.$inject = ['$http', '$stateParams', '$location', 'CampaignsService'];

export default singleCampaignCtrl;