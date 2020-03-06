/* eslint-disable no-undef */
class ReferencesService {
    constructor($http, $log, $window, NetworkService) {
        this.$http = $http;
        this.log = $log.log;
        this.$sessionStorage = $window.sessionStorage;
        this.networkService = NetworkService;
        //this.API_URL = 'https://museum-grodno.000webhostapp.com/wp-json/museum-funds/v1/references';
        this.API_URL = 'http://localhost/wordpress/wp-json/museum-funds/v1/references';
        this.headersRef = angular.copy(this.networkService.headersDefault);
        this.headersRef['Authorization'] = 'Bearer '+ this.$sessionStorage.getItem('token');
        this.log(this.headersRef );
        //this.getAllReferences();
        }

    getAllReferences(){
        this.$http({
            method: "GET",
            url: this.API_URL,

           headers:{
                'Access-Control-Allow-Origin': '*',
                'Access-Control-Allow-Methods': 'POST, GET, OPTIONS, PUT, DELETE',
                'Access-Control-Allow-Headers': 'Content-Type, X-Auth-Token, Origin',
                'Authorization':'Bearer '+ this.$sessionStorage.getItem('token')
            }
       })

        .then( response => {
           this.$sessionStorage.setItem('refList', response.data);
        })

        .catch(function (error) {
            this.log(error);
        });
    }

    getReferencesValue(id){
        this.$http({
            method: "GET",
            url: this.API_URL+'/'+id+'/value',

            headers:{
                'Access-Control-Allow-Origin': '*',
                'Access-Control-Allow-Methods': 'POST, GET, OPTIONS, PUT, DELETE',
                'Access-Control-Allow-Headers': 'Content-Type, X-Auth-Token, Origin',
                'Authorization':'Bearer '+ this.$sessionStorage.getItem('token')
            }
        })

            .then( response => {
                this.$sessionStorage.setItem('refListValue', response.data);
            })

            .catch(function (error) {
                this.log(error);
            });
    }


}

ReferencesService.$inject = ["$http","$log", "$window", "NetworkService"];

export { ReferencesService };
