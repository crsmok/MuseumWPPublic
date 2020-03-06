export default class ReferencesController {
    constructor( $scope, $log, $http, $state, ReferencesService) {
        // self = this;
        this.title = "LoginComponent";
        this.log = $log.log;
        this.$http = $http;
        this.$scope = $scope;
        this.state = $state;
        this.disableForm = false;
        this.referencesService = ReferencesService;
        //this.refListWithValue = JSON.parse(this.referencesService.$sessionStorage.getItem('refList'));
       // this.refList = this.getRefList(this.refListWithValue);
      //  this.refListValue = this.refListWithValue[0].value;
    }

    getRefList(data){
        let result = [];
        data.forEach((item)=>{
            result.push(item.ref);
        });

        return result;
    }

    editRef(nuberRef){

        this.log(nuberRef);
    }

    viewRef(ref_id){
        this.refListValue = this.refListWithValue[ref_id].value;
    }

}

ReferencesController.$inject = [ "$scope", "$log", "$http", "$state", "ReferencesService"];