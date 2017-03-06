/**
 * Created by mikhailnazarov on 03.03.17.
 */
(function () {
  angular.module('shortenerApp').controller('IndexController',['$http','$location',function ($http,$location) {
      var vm = this;
      vm.full_url = "";
      vm.encoded = "";
      vm.submit = function() {
          var req = {
            full_url:vm.full_url,
            encoded:vm.encoded
          };
          var data = JSON.stringify(req);
          // Simple GET request example:
          $http({
              method: 'POST',
              url: window.location.origin+"/api/v1/create",
              headers: {'Content-Type': 'application/x-www-form-urlencoded'},
              data:data
          }).then(function successCallback(response) {
              vm.link = $location.absUrl() + response.data.encoded;
              vm.errors = null;
          }, function errorCallback(response) {
              vm.errors = response.data.errors
              vm.link = null;
          });
      }
  }]);
})();