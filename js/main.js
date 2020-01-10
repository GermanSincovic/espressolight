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
	"owner_id": "Владелец (ID)",
	"comment": "Комментарий"
};

function toggleSpinner(){
	$("#navigation").toggleClass("blur");
	$("#main").toggleClass("blur");
	$("#spinner").toggleClass("hidden");
}

function switchNavBtn(){
	$("#nav-controls > li").removeClass('active');
	$("[data-route='" + window.location.hash.replace('#', '') + "']").parent().addClass('active');
}

function showData(){
	var hComponent = window.location.hash.replace('#', '');
	if (hComponent) {
		new DataWorkshop("GET", hComponent, "", TableDrawer);
		$("#main").removeClass("hidden");
	}
}

$("#nav-controls")[0].addEventListener('click', function(e){
	window.location.hash = e.target.dataset.route;
});

window.onload = function(){ switchNavBtn(); showData();}
window.onhashchange = function(){ switchNavBtn(); showData();}
