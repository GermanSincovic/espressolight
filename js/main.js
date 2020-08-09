import {Router} from './modules/Router.js';
import {RequestController} from './modules/RequestController.js';
import {ViewManager} from "./modules/ViewManager.js";

$( document ).ready( () => {
		Router.init();
		ViewManager.toggleActiveHeaderLink();
	}
);

$(window).on('popstate', function(e){
	Router.init();
	ViewManager.toggleActiveHeaderLink();
});

$("body").on("click", "a", function (e){
	e.preventDefault();
	Router.redirectTo(e.currentTarget.href);
	Router.init();
	ViewManager.toggleActiveHeaderLink();
});

$("#login_btn").click(function(){
	RequestController.login();
});
$("#logout").click(function(){
	RequestController.logout();
});