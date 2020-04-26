import {Router} from './modules/Router.js';
import {RequestController} from './modules/RequestController.js';

$( document ).ready( Router.init() );

$("body").on("click", "a", function (e){
	e.preventDefault();
	history.replaceState(null, null, e.currentTarget.href);
	Router.init();
});

$("#login_btn").click(function(){
	RequestController.login();
});
$("#logout").click(function(){
	RequestController.logout();
});