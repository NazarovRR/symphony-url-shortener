/**
 * Created by mikhailnazarov on 03.03.17.
 */
(function () {
  angular.module('shortenerApp').controller('IndexController',['$http',function ($http) {
      var vm = this;
      vm.full_url = "";
      vm.encoded = "";
      vm.submit = function() {
          var req = {
            full_url:vm.full_url,
            encoded:vm.encoded
          };
          var data = JSON.stringify(req);
          alert(data);
          // Simple GET request example:
          $http({
              method: 'POST',
              url: window.location.origin+"/api/v1/create",
              data:data
          }).then(function successCallback(response) {
              alert(response.status);
              // var data = JSON.parse(response.data);
              alert(response.data);
          }, function errorCallback(response) {
              alert(response.status);
              alert("lol");
          });
      }
  }]);
})();