function switchNavBtn(){
	$("#nav-controls > div").removeClass('active');
	$("#nav-controls > [data-route='" + window.location.hash.replace('#', '') + "']").addClass('active');
}

function showData(){
	var hComponent = window.location.hash.replace('#', '');
	if (hComponent) {
		var data_workshop = new DataWorkshop(hComponent);
			data_workshop.getData(TableDrawer);
	}
}

$("#nav-controls")[0].addEventListener('click', function(e){
	window.location.hash = e.target.dataset.route;
});

window.onload = function(){ switchNavBtn(); showData(); }
window.onhashchange = function(){ switchNavBtn(); showData(); }