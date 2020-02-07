function DataLister(data, target){

	this.wrapper = document.createElement('div');
	this.wrapper.className = "list-group";

	this.addLine = function(text, link){
		// var el = document.createElement('li');
		// 	el.className = "list-group-item";
		var a = document.createElement('a');
			a.className = "list-group-item list-group-item-action";
			a.href = link;
			a.innerText = text;
			// el.append(a);
			this.wrapper.append(a);
	}

	if(data.length > 0){
		for (var key in data){
			this.addLine(data[key].name + ' ' + data[key].surname, window.location.href + "/" + data[key].id);
		}
		target.html(this.wrapper);
	} else {
		target.html("<span>Нечего показать...</span>");
	}

	
}