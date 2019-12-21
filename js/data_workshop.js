function DataWorkshop(method, component, data, callback){

	this.method = method;
	this.component = component;
	this.data = data;

	this.getData = function(){
		$.ajax({
	        url: "/api/" + this.component,
	        type: this.method,
	        data: data,
	        beforeSend: function () {
				toggleSpinner();
			},
			dataType: "json",
	        success: function(data){
				toggleSpinner();
				callback(data);
			} 
		});
	}

	switch (this.method){
		case "GET": this.getData(); break;
	}


}

