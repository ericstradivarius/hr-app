class headerCtrl {

    constructor($http, userService, Upload, $location, headerService) {

        this.$http = $http;
        this.showAddCampaign = false;
        this.showAddCandidate = false;
        this.Upload = Upload;
        this.picFile = null;
        const self = this;
        this.userService = userService;
        this.allItems = [];
        this.$location = $location;
        //get current logged user
        self.userData = {};
        this.userService.getCurrentUser().then(function(result){
            self.userData = result;
        });
        this.getAllCampaigns();
        this.getAllCandidates();
        this.headerErrors = '';
        this.updateSuccess = false;
        this.selected = undefined;
        this.headerService = headerService;

    }

    logout() {
        const self = this;
        self.$http.post('/logout').then(function() {
            window.location = '/';
            //self.$localStorage.$reset();
        }, function() {
            window.location = '/';
            //self.$localStorage.$reset();
        });
    };

    uploadPic(file, userId) {

        const self = this;

        file.upload = self.Upload.upload({
            url:'/files',
            method: 'post',
            data: {
                file: file,
                type: 'image',
                entity: userId,
                purpose: 'Avatar picture'
            }
        });

        file.upload.then(
            function(response){
                self.saveUserData(self.userData, response.data.data.id);
                self.userService.getCurrentUser().then(function(result){
                    self.userData = result;
                });
            },
            function(response) {
                if(response.status > 0)
                    self.errorMsg = response.status + ':' + response.data;
            },
            function(evt) {
                //Math.min is to fix IE which reports 200% sometimes
                file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
            }
        );
    }

    //Edit profile
    saveUserData(user, fileResultId) {

        const self = this;
        this.$http({
            method: 'put',
            url: '/users/' + self.userData.id,
            headers: {
                "accept": "application/json"
            },
            data: {
                "name": user.name,
                "email": user.email,
                "password": user.password,
                "password_confirmation": user.password_confirmation,
                "images": [fileResultId]
            }
        }).then(
            function (response) {
                // window.alert('Your profile has been updated!');
                self.updateSuccess = true;
                $('#editProfileModal').modal('hide');
                self.headerSuccess=true;
                self.headerErrors=false;
            },
            function (error) {
                self.headerErrors = error.data.errors;
            });

    }

    //Edit profile
    saveUserDataNoFiles(user) {

        const self = this;

        this.$http({
            method: 'put',
            url: '/users/' + self.userData.id,
            headers: {
                "accept": "application/json"
            },
            data: {
                "name": user.name,
                "email": user.email,
                "password": user.password,
                "password_confirmation": user.password_confirmation
            }
        }).then(
            function (response) {
                $('#editProfileModal').modal('hide');
                self.updateSuccess = true;
                self.headerSuccess=true;
                self.headerErrors=false;
            },
            function (error) {
                self.headerErrors = error.data.errors;
            });

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
                for(let i = 0; i < response.data.data.length; i++){
                    let item = {};
                    item.name = response.data.data[i].name;
                    item.group = 'campaigns';
                    item.id = response.data.data[i].id;
                    self.allItems.push(item);
                }
            },
            function (error) {
                self.allCampaignsArrayErrors = error.data.errors;
            }
        );
    };

    getAllCandidates() {
        const self = this;
        this.$http({
            method: 'get',
            url: '/candidates',
            headers: {
                "accept": "application/json",
            }
        }).then(
            function (response) {
                for(let i = 0; i < response.data.data.length; i++){
                    let item = {};
                    item.name = response.data.data[i].first_name + ' ' + response.data.data[i].last_name;
                    item.group = 'candidates';
                    item.id = response.data.data[i].id;
                    self.allItems.push(item);
                }
            },
            function (error) {
                self.allCandidatesErrors = error.data.errors;
            }
        )
    };

    onSelect($item, $model, $label) {
        const self = this;
        for(let i = 0; i< self.allItems.length; i++) {
            if(self.allItems[i].name === $item.name) {
                self.$location.path('/' + self.allItems[i].group + '/' + self.allItems[i].id);
                self.$location.replace();
            }
        }
    }

}

headerCtrl.$inject = ['$http', 'userService', 'Upload', '$location', 'headerService'];

export default headerCtrl;
