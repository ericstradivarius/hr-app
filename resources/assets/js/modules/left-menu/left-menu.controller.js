class leftMenuCtrl {

    constructor($route, $location) {

        /*console.log($route);

        $route.reload();

        if($location.path() === "/"){
            $location.path('/campaigns').replace();
            console.log('this was the replace');
        }*/

        this.classCandidates = null;
        this.classCampaigns = 'active';
        this.classBorderCampaigns = 'active-border';
        this.classBorderCandidates = 'hidden-border';

    }

    changeClassCandidates(){
        const self = this;

        self.classCandidates = 'active';
        self.classCampaigns = null;

        self.classBorderCampaigns = "hidden-border";
        self.classBorderCandidates = "active-border";
        self.classBorderNewCampaign = "new-button-inactive";
        self.classBorderNewCandidate = "new-button-active";


    };

    changeClassCampaigns(){

        const self = this;

        self.classCandidates = null;
        self.classCampaigns = 'active';

        self.classBorderCampaigns = "active-border";
        self.classBorderCandidates = "hidden-border";
        self.classBorderNewCampaign = "new-button-active";
        self.classBorderNewCandidate = "new-button-inactive";

    };

}

leftMenuCtrl.$inject = ['$route', '$location'];
export default leftMenuCtrl;
