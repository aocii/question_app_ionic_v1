angular.module('starter.controllers', [])

.controller('AppCtrl', function($scope, $ionicModal, $timeout) {


  $scope.loginData = {};

  
  $ionicModal.fromTemplateUrl('templates/login.html', {
    scope: $scope
  }).then(function(modal) {
    $scope.modal = modal;
  });

  
  $scope.closeLogin = function() {
    $scope.modal.hide();
  };


  $scope.login = function() {
    $scope.modal.show();
  };

 
  $scope.doLogin = function() {
    console.log('Doing login', $scope.loginData);


    $timeout(function() {
      $scope.closeLogin();
    }, 1000);
  };
})

.controller('haberCtrl', function($scope, $stateParams){

  console.log("ggg");
$scope.haberler = [
{adi:'yıldız teknikte kaza', id: 0 },
{adi:'cahil çocuk teker yaptı',  id: 1 }

];



})

.controller("habeCtrl", function($scope){
  console.log("tıkladın gardaşım")
})

.controller('PlaylistCtrl', function($scope, $stateParams) {
});
