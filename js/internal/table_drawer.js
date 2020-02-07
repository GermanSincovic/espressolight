function TableDrawer(data, target){

	if (Object.keys(data).length > 0){

		var table = document.createElement('table');
			table.className = "table table-bordered table-sm table-hover";
		var thead = table.createTHead();
			thead.className = "thead-light";
		var thead_row = thead.insertRow();

		for(var key in data[Object.keys(data)[0]]){
			var thead_cell = thead_row.appendChild(document.createElement("th"));
				thead_cell.setAttribute("scope","col");
				thead_cell.dataset.name = key;
				thead_cell.innerText = head_name_arr[key];
		}

			var thead_cell = thead_row.appendChild(document.createElement("th"));
				thead_cell.setAttribute("scope","col");
			var edit_btn = document.createElement('button');
				edit_btn.type = "button";
				edit_btn.className = "badge btn btn-success my-2 my-sm-0 w-100";
				edit_btn.dataset.action = "create";
				edit_btn.innerText = 'Создать';
				thead_cell.appendChild(edit_btn);

		var tbody = table.createTBody();
		
		for (var key in data) {

			var tbody_row = tbody.insertRow();
			
			for(var inner_key in data[key]){
				var tbody_cell = tbody_row.insertCell();
				tbody_cell.dataset.name = inner_key;
				tbody_cell.innerText = data[key][inner_key];
			}

			var tbody_cell = tbody_row.insertCell();

				var edit_btn = document.createElement('button');
					edit_btn.type = "button";
					edit_btn.className = "badge btn btn-outline-info my-2 my-sm-0 w-50";
					edit_btn.innerText = 'Изменить';
					edit_btn.dataset.id = key;
					edit_btn.dataset.action = "edit";
				tbody_cell.appendChild(edit_btn);

				var edit_btn = document.createElement('button');
					edit_btn.type = "button";
					edit_btn.className = "badge btn btn-outline-danger my-2 my-sm-0 w-50";
					edit_btn.innerText = 'Удалить';
					edit_btn.dataset.id = key;
					edit_btn.dataset.action = "delete";
				tbody_cell.appendChild(edit_btn);

		}


		target.html(table);

	} else {

		target.html(`<div class="d-flex justify-content-between"><span>Записей нет</span><button data-id="new" class="badge btn btn-success my-2 my-sm-0">New</button></div>`);

	}
}

