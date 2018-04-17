import CampaignsService from '../campaigns/campaigns.service';

class singleCandidateCtrl {

    constructor($http, $stateParams,$location, Upload, CampaignsService) {
        this.$http = $http;
        //this.selectedId = 1;
        this.getDataSingleCandidate($stateParams.id, $http);
        this.getAllCampaigns();
        this.CampaignsService = CampaignsService;

        this.Upload = Upload;
        this.candidate = {};
        this.$location = $location;
    }


    getAllCampaigns() {
        const self = this;
        this.$http({
            method: 'get',
            url: '/campaigns',
            headers: {
                "accept": "application/json",
            }
        }).then(
            function (response) {
                self.allCampaignsArray = response.data.data;
                self.selectedCampaign = self.selectedId;
            },
            function (error) {
                self.addCandidateErrors = error.data.errors;
            }
        )
    };


    getDataSingleCandidate(cadidateId) {
        const self = this;
        this.$http({
            method: 'get',
            url: '/candidates/'+cadidateId,
            headers: {
                "accept": "application/json",
            },
            params:{
                'with[]':['campaigns','files']
            }
        }).then(
            function (response) {
                self.singleCandidateData = response.data.data;
                self.singleCandidateData.name = self.singleCandidateData.first_name + ' ' + self.singleCandidateData.last_name;
                self.selectedId = response.data.data.campaigns[0].id;
                self.getOthersCandidatesFromCampaign(response.data.data.campaigns[0].id);

            },
            function (error) {
                self.errors = error.data.errors;
            }
        )
    };


    getOthersCandidatesFromCampaign(campaignId) {
        const self = this;
        this.$http({
            method : 'get',
            url: '/campaigns/' + campaignId,
            headers: {
                "accept": "application/json"
            },
            params: {
                'with[]': ['candidates']
            }
        }).then(
            function(response){
                self.othersCandidatesFrom = response.data.data.candidates;
            },
            function (error) {
                self.errors = error.data.errors;
            }
        )
    }



    deleteCandidate(candidateId) {
        const self = this;

        this.$http({
            method : 'delete',
            url: '/candidates/' + candidateId,
            headers: {
                "accept": "application/json"
            }
        }).then(
            function(response){

                $('#deleteCandidateModal').modal('hide');
                self.$location.path('/candidates');
                self.$location.replace();

            },
            function (error) {
                self.errors = error.data.errors;
            }
        )
    }


    updateCandidateInfo(user,candidateId, campaignFileId) {
        const self = this;


        if(campaignFileId)
        self.candidate = {
            "first_name": user.first_name,
            "last_name": user.last_name,
            "email": user.email,
            "phone": user.phone,
            "stage": user.stage,
            "status": user.status,
            "dob": moment(user.dob).format('YYYY-MM-DD'),
            "campaigns": [self.selectedCampaign],
            "cv" : campaignFileId}
            else
        self.candidate ={
            "first_name": user.first_name,
            "last_name": user.last_name,
            "email": user.email,
            "phone": user.phone,
            "stage": user.stage,
            "status": user.status,
            "dob": moment(user.dob).format('YYYY-MM-DD'),
            "campaigns": [self.selectedCampaign]}

        this.$http({
            method: 'put',
            url: '/candidates/'+candidateId,
            headers: {
                "accept": "application/json",
            },
            params: {
                'with[]':['campaigns','files']
            },
            data: self.candidate
        }).then(
            function (response) {
                self.updatedCandidate = response.data.data;

                $('#myModal').modal('hide');
                confirm("Candidate data has been updated !");
            },
            function (error) {
                self.errors = error.data.errors;
            }
        )
    };




    uploadFile(array,file, campaignId){

        const self = this;

        if(file) {


        file.upload = self.Upload.upload({
            url:'/files',
            data: {
                file: file ,
                type: 'document',
                entity: 'candidates',
                purpose: 'Candidate CV'
            }
        });

        file.upload.then(function(response){
                self.campaignFileId = response.data.data.id;
                self.updateCandidateInfo(array, array.id, response.data.data.id);

            }, function(response) {
                if(response.status > 0)
                    self.errorMsg = response.status + ':' + response.data;
            }, function(evt) {
                //Math.min is to fix IE which reports 200%
                file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
            }
        );
        }
        else {
            self.updateCandidateInfo(array, array.id);
        }

    }



}

singleCandidateCtrl.$inject = ['$http', '$stateParams','$location', 'Upload'];

export default singleCandidateCtrl;