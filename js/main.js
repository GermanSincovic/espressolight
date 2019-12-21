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

window.onload = function(){ switchNavBtn(); showData(); toggleSpinner();}
window.onhashchange = function(){ switchNavBtn(); showData(); toggleSpinner();}

