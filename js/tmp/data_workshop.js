function DataWorkshop(method, component, data, callback){
	$.ajax({
        url: "/api/" + component,
        type: method,
        data: data,
        beforeSend: function () {
			toggleSpinner();
		},
		dataType: "json",
        success: function(data){
			callback(data, $("#main"));
		},
		complete: function(){
			toggleSpinner();
		}
	});
}

