class NetworkService {
    constructor($http, $log,$window, $state) {
        this.$http = $http;
        this.log = $log.log;
        this.$sessionStorage = $window.sessionStorage;
        this.$state = $state;
        // this.API_URL = 'https://museum-grodno.000webhostapp.com/wp-json/jwt-auth/v1/token';
        this.API_URL = 'http://localhost/wordpress/wp-json/';
        this.headersDefault = {
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Methods': 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers': 'Content-Type, X-Auth-Token, Origin'
        }


    }

    sendPost (endPoint, userData, headers, /*nameSpaceObject ,*/callBack, backError ){
        this.$http({
            method: "POST",
            url: this.API_URL+endPoint,

            data: userData,

            headers: headers
        })

            .then( (response)=> {
                callBack.call(this, response.data);
            })

            .catch( (error) =>{
                backError.call(this, error);
            });
    }

    sendGet (endPoint, userData, headers, /*nameSpaceObject ,*/callBack, backError ){
        this.$http({
            method: "GET",
            url: this.API_URL+endPoint,
            headers: headers
            })
            .then( (response)=> {
                callBack.call(this, response.data);
            })
            .catch( (error) =>{
                backError.call(this, error);
            });
    }

}

NetworkService.$inject = ["$http","$log", "$window", "$state"];

export { NetworkService };