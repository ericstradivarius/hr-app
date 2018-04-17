class addCandidateCtrl {

    constructor($http, headerService, Upload) {

        this.$http = $http;
        this.headerService = headerService;
        this.Upload = Upload;

        //init all campaigns
        this.allCampaignsArray = [];
        this.getAllCampaigns();

        //init candidate
        this.candidate_first_name = '';
        this.candidate_last_name = '';
        this.candidate_email = '';
        this.candidate_phone = '';
        this.select_stage = '';
        this.select_state = '';
        this.candidate_dob = '';
        this.multipleSelect = '';
        this.candidate_cv = null;
        this.campaignFileId = null;

    }

    sendCandidate(campaignFileId) {
        const self = this;

        console.log('campaign file id ',campaignFileId);

        if(campaignFileId === null){
            console.log('if campaign file id ',campaignFileId);
            self.$http({
                method: 'post',
                url: '/candidates',
                headers: {
                    "accept": "application/json",
                },
                data: {
                    "first_name": self.candidate_first_name,
                    "last_name": self.candidate_last_name,
                    "email": self.candidate_email,
                    "phone": self.candidate_phone,
                    "stage": self.select_stage,
                    "status": self.select_state,
                    "dob": self.candidate_dob ? self.candidate_dob.format('YYYY-MM-DD'):'',
                    "campaigns" : self.multipleSelect,
                }
            }).then(
                function (response) {
                    confirm("Your candidate has been added successfully!");
                    // Reset fields
                    self.candidate_first_name = '';
                    self.candidate_last_name = '';
                    self.candidate_email = '';
                    self.candidate_phone = '';
                    self.select_stage = '';
                    self.select_state = '';
                    self.candidate_dob = '';
                    self.multipleSelect = '';
                },
                function (error) {
                    self.addCandidateErrors = error.data.errors;
                }
            )
        }
        else {
            self.$http({
                method: 'post',
                url: '/candidates',
                headers: {
                    "accept": "application/json",
                },
                data: {
                    "first_name": self.candidate_first_name,
                    "last_name": self.candidate_last_name,
                    "email": self.candidate_email,
                    "phone": self.candidate_phone,
                    "stage": self.select_stage,
                    "status": self.select_state,
                    "dob": self.candidate_dob ? self.candidate_dob.format('YYYY-MM-DD'):'',
                    "campaigns" : self.multipleSelect,
                    "cv":[campaignFileId]
                }
            }).then(
                function (response) {
                    confirm("Your candidate has been added successfully!");
                    // Reset fields
                    self.candidate_first_name = '';
                    self.candidate_last_name = '';
                    self.candidate_email = '';
                    self.candidate_phone = '';
                    self.select_stage = '';
                    self.select_state = '';
                    self.candidate_dob = '';
                    self.multipleSelect = '';
                    self.candidate_cv = '';
                },
                function (error) {
                    self.addCandidateErrors = error.data.errors;
                }
            )
        }

    };

    uploadFile(file){
        const self = this;

        if(file === null){
            self.sendCandidate(null);
        }
        else {
            file.upload = self.Upload.upload({
                url:'/files',
                data: {
                    file: file,
                    type: 'document',
                    entity: 'candidates',
                    purpose: 'Candidate CV'
                }
            });

            file.upload.then(function(response){
                    self.campaignFileId = response.data.data.id;
                    self.sendCandidate(self.campaignFileId);
                }, function(response) {
                    if(response.status > 0)
                        self.errorMsg = response.status + ':' + response.data;
                }, function(evt) {
                    //Math.min is to fix IE which reports 200%
                    file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
                }
            );
        }

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
            },
            function (error) {
                self.addCandidateErrors = error.data.errors;
            }
        )
    };

}

addCandidateCtrl.$inject = ['$http', 'headerService', 'Upload'];
export default addCandidateCtrl;
