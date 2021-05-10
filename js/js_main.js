var app_main = angular.module('app_main', ['ngRoute', 'ngCookies']);
var URL = "http://localhost/Proj_1/#!/";

app_main.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/', {
          templateUrl: 'templates/components/post.html',
          controller: 'PostController'
      });
}]);
app_main.controller('PostController', ['$scope', '$http', '$window', function ($scope, $http, $window){
  $http({
    method: 'get',
    url: 'php/getData.php'
  }).then(function successCallback(response) {
    $scope.posts = response.data;
   });

  $http({
    method: 'get',
    url: 'php/getComment.php'
  }).then(function successCallback(response) {
    $scope.comments = response.data;
  });

   $scope.submitPost = function () {

      $http({
        method: "POST",
        url: "php/post.php",
        data:{'description':$scope.text, 'title':$scope.title}
        }).then(function(data){
          $window.location.reload();
          var modal_popup = angular.element('#postModal');
          modal_popup.modal('hide');
       });
    };

    $scope.deletePost = function (id) {
       $http({
         method: "DELETE",
         url: "php/delete.php",
         data:{'id':id}
       }).then(function(data){
         $window.location.reload();
       });
     };
     
     $scope.deleteComment = function (id) {
        $http({
          method: "DELETE",
          url: "php/cdelete.php",
          data:{'id':id}
        }).then(function(data){
          $window.location.reload();
        });
      };
    $scope.submitComment = function (id, text) {
      $http({
        method: "POST",
        url: "php/cpost.php",
        data:{'content':text, 'post_Id':id}
      }).then(function(data){
        $window.location.reload();
        var modal_popup = angular.element('#commentModal');
        modal_popup.modal('hide');
      });
    };


}]);
