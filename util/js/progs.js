$app = angular.module('progs', ['ui.tinymce']);

$app.config(function($routeProvider){

	$routeProvider.

	when('/', {
		templateUrl: 'index.php/site/home',
		controller: homeController
	}).
	when('/contato', {
		templateUrl: 'index.php/site/contato',
		controller: 'contatoController'
	}).
	when('/bootstrap', {
		templateUrl: 'index.php/site/bootstrap',
		controller: ''
	}).
	when('/trabalhos', {
		templateUrl: 'index.php/site/trabalhos',
		controller: ''
	}).
	when('/sobrenos', {
		templateUrl: 'index.php/site/empresa',
		controller: ''
	}).
	when('/cursos', {
		templateUrl: 'index.php/site/cursos',
		controller: ''
	}).

	when('/eventos', {
		templateUrl: 'index.php/site/eventos',
		controller: ''
	}).

	otherwise({ redirectTo:'/' });



});


	function homeController(){}


function contatoController($scope,$http,$location){


$scope.enviar = function(){

  $http.post('index.php/site/enviar',$scope.user).success(function(){
  alert("enviado em breve entraremos em contato");
  $location.path('/');
  });
 }


 }  



