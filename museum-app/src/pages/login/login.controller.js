export default class LoginController {
    constructor($scope, $log, $http, LoginService) {
        this.title = "LoginComponent";
        this.log = $log.log;
        this.$http = $http;
        this.$scope = $scope;
        this.disableForm = false;
        this.loginService = LoginService;

        this.user = {
            login: null,
            password: null
        };

        this.$scope.$watch(this.loginService.loginData, (newValue)=>{
            this.loginService.loginData = newValue;
        });

        this.$scope.$watch(this.loginService.userLogin, (newValue)=>{
            this.disableForm= newValue;
        });
    }

    signIn() {
        this.disableForm = true;
        this.loginService.auth(this.user);
    }

    logOut() {
        this.disableForm = false;
        this.loginService.logout();
    }

    /*hasError() {
      this.log(this.$scope.auth.login.$invalid && this.$scope.auth.$submitted);
      return this.$scope.auth.login.$invalid && this.$scope.auth.$submitted;
    }*/

}

LoginController.$inject = ["$scope", "$log", "$http", "LoginService"];