function DataWorkshop(method, component, data, callback){
	$.ajax({
        url: "/api/" + component,
        type: method,
        data: data,
        beforeSend: function () {
			toggleSpinner();
		},
		dataType: "json",
		// error: function(data, status) {
	 //        console.log('Error: data -> ' + data + ' :: status -> ' + status);
	 //    },
        success: function(data){
			callback(data);
			// console.log(data);
		},
		complete: function(){
			toggleSpinner();
		}
	});
}

