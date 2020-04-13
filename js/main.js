import {Router} from './modules/Router.js';

$( document ).ready( Router.init() );

$("body").on("click", "a", function (e){
	e.preventDefault();
	history.pushState(null, null, e.currentTarget.href);
	Router.init();
});

var head_name_arr = {
	"id": "ID",
	"name": "Имя",
	"surname": "Фамилия",
	"login": "Логин",
	"password": "Пароль",
	"email": "E-mail",
	"role": "Роль",
	"photo": "Фото",
	"company": "Компания",
	"created": "Создан",
	"active": "Активен",
	"phone": "Телефон",
	"token": "Токен",
	"cid": "Компания (ID)",
	"cname": "Компания",
	"uid": "Владелец (ID)",
	"comment": "Комментарий"
};

function toggleSpinner(){
	$("#navigation").toggleClass("blur");
	$("#main").toggleClass("blur");
	$("#spinner").toggleClass("hidden");
}

function showData(){
	var hComponent = window.location.hash.replace('#', '');
	if (hComponent) {
		DataWorkshop("GET", hComponent, "", DataLister);
		$("#main").removeClass("hidden");
	}
}

$("#nav-controls")[0].addEventListener('click', function(e){
	window.location.hash = e.target.dataset.route;
});

function switchNavBtn(){
	$("#nav-controls > li").removeClass('active');
	$("[data-route='" + window.location.hash.replace('#', '') + "']").parent().addClass('active');
}

window.onload = function(){ switchNavBtn(); showData();}
window.onhashchange = function(){ switchNavBtn(); showData();}
