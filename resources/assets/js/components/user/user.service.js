function userService($http) {
    let userObject = {};
    let user = {
        name: 'no fucking name'
    };

    userObject.getCurrentUser = function() {

         let userRequest = $http({

            method: 'get',
            url: '/user',
            headers: {
                "accept": "application/json"
            },
             params: {
                 'with[]' : ['files']
             }

        }).then(

                function(response) {
                    return response.data.data;
                },
                function(error) {

                }
        );

        return userRequest;

    };

    return userObject;
}

userService.$inject = ['$http'];
export default userService;