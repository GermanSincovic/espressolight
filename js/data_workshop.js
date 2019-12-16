function DataWorkshop(component){

	this.component = component;

	this.getData = function(callback){
		$.ajax({
	        url: "/api/" + this.component,
	        type: "GET",
	        beforeSend: function () {
	        	$("#main").html("<div id='spinner'></div>");
			},
			dataType: "json",
	        success: function(data){
	        	// $("#main").html("<div id='spinner'></div>");
	        	callback(data);
			} 
		});
	}
}

