function DataLister(data, target){

	this.wrapper = document.createElement('ul');
	this.wrapper.className = "list-group";

	this.addLine = function(text, link){
		var el = document.createElement('li');
			el.className = "list-group-item";
		var a = document.createElement('a');
			a.className = "list-group-item";
			a.href = link;
			a.innerText = text;
			el.append(a);
			this.wrapper.append(el);
	}

	if(data.length > 0){
		for (var key in data){
			this.addLine(data[key].name + data[key].surname, window.location.href + "/" + data[key].id);
		}
		target.append(this.wrapper);
	} else {
		target.append("<span>Нечего показать...</span>");
	}

	
}