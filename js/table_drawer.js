function TableDrawer(data){

	if (Object.keys(data).length > 0){

		var table = document.createElement('table');
		var thead = table.createTHead();
		var thead_row = thead.insertRow();

		for(var key in data[Object.keys(data)[0]]){
			var thead_cell = thead_row.insertCell();
				thead_cell.innerText = key;
		}

		var tbody = table.createTBody();
		
		for (var key in data) {

			var tbody_row = tbody.insertRow();
			
			for(var inner_key in data[key]){
				var tbody_cell = tbody_row.insertCell();
				tbody_cell.innerText = data[key][inner_key];
			}

			var tbody_cell = tbody_row.insertCell();
			
			var control_btns = document.createElement('div');
				control_btns.className = 'control_btns';

				var edit_btn = document.createElement('button');
					edit_btn.dataset.id = key;
					edit_btn.innerText = 'Edit';
				control_btns.appendChild(edit_btn);
				tbody_cell.appendChild(control_btns);

				var edit_btn = document.createElement('button');
					edit_btn.dataset.id = key;
					edit_btn.innerText = 'Delete';
				control_btns.appendChild(edit_btn);
				tbody_cell.appendChild(control_btns);

		}

		$("#main").html(table);

	} else {

		$("#main").html('asdasd');

	}
}

