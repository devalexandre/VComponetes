$app = angular.module('administration', []);

$app.config(function($routeProvider){

	$routeProvider.
	
	when('/category', {
		templateUrl: 'index.php/c_category',
		controller: categoryController
	}).
	when('/articles', {
		templateUrl: 'index.php/c_articles',
		controller: 'articlesController'
	}).
	when('/projects', {
		templateUrl: 'index.php/c_projects',
		controller: 'projectsController'
	}).
	when('/user', {
		templateUrl: 'index.php/c_user',
		controller: 'userController'
	}).
when('/login', {
		templateUrl: 'index.php/adm/login',
		controller: 'loginController'
	}).

	otherwise({ redirectTo:'/login' });


	function homeController(){}
});