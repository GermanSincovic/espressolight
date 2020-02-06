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
			// callback(data);
			console.log(data[0]);
			$("#main")[0].innerText = data[0];
		},
		complete: function(){
			toggleSpinner();
		}
	});
}

