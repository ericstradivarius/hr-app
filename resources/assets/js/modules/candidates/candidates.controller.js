class CandidatesCtrl {

    constructor($http) {
        this.candidatesArray = [];
        this.candidateNumberOfPages = [];
        this.candidatesPerPage = 3;
        this.$http = $http;
        this.numberOfCandidates();
        //sort init
        this.propertyName = 'first_name';
        this.sortBy = 'desc';
        //endOf sort init
        this.pageNumber = 1;
        this.showCandidates(this.pageNumber, this.propertyName);
    }

    numberOfCandidates() {
        const self = this;
        this.$http({
            method: 'get',
            url: '/candidates/count',
            headers: {
                "accept": "application/json",
            }
        }).then(
            function(response) {
                self.candidateNumberOfPages = new Array(Math.ceil(response.data.data.count / self.candidatesPerPage));
            }
        )
    };

    showCandidates (pageNumber, propertyName) {
        const self = this;
        self.propertyName = propertyName;

        if(pageNumber === self.pageNumber) {
            self.sortBy = (self.sortBy === 'asc') ? 'desc' : 'asc';
        }

        self.pageNumber = pageNumber;

        this.$http({
            method: 'get',
            url: '/candidates/',
            headers: {
                "accept": "application/json",
            },
            params: {
                'with[]':['campaigns'],
                'per_page': this.candidatesPerPage,
                'order_by_type[]': self.sortBy,
                'order_by_column[]': self.propertyName,
                'page': pageNumber
            },
        }).then(
            function (response) {
                self.candidatesArray = response.data.data.data.map((item) => {
                    item.name = item.first_name + ' ' + item.last_name;
                    return item;
                });
            },
            function (error) {
                this.errors = error.data.errors;
            }
        )
    };

}

CandidatesCtrl.$inject = ['$http'];
export default CandidatesCtrl;