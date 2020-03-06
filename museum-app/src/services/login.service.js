
class LoginService {
  constructor($http, $log, NetworkService, $window, $state) {
    this.$http = $http;
    this.log = $log.log;
    this.$sessionStorage = $window.sessionStorage;
    this.$state = $state;
    this.networkService = NetworkService;
    this.userLogin = false;

  }

  getError(err){
      this.log(err);
      this.userLogin = false;
  }

  getToken(data){
      this.userLogin = true;
      this.$sessionStorage.setItem('token', data.token);
      this.$state.go('maindesk');
  }

  auth(userProfile){
      //token = this.$sessionStorage.getItem('token');
      //this.getToken(userProfile);
      this.networkService.sendPost('jwt-auth/v1/token',{username: userProfile.login, password: userProfile.password},
                                    this.networkService.headersDefault, this.getToken, this.getError);
     // if()
  }

  logout(){
      this.$sessionStorage.clear();
  }

  updateData(data){
    this.$http.put(this.API_URL, JSON.stringify(data));
  }


}

LoginService.$inject = ["$http","$log","NetworkService",  "$window", "$state"];

export { LoginService };