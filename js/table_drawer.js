function TableDrawer(data){

	var head_name_arr = {
		"id": "ID",
		"name": "Имя",
		"surname": "Фамилия",
		"login": "Логин",
		"password": "Пароль",
		"role": "Роль",
		"photo": "Фото",
		"company": "Компания",
		"comment": "Комментарий"
	};

	if (Object.keys(data).length > 0){

		var table = document.createElement('table');
			table.className = "table table-bordered table-sm table-hover";
		var thead = table.createTHead();
			thead.className = "thead-light";
		var thead_row = thead.insertRow();

		for(var key in data[Object.keys(data)[0]]){
			if(key == "password" || key == "photo"){ continue; }
			var thead_cell = thead_row.appendChild(document.createElement("th"));
				thead_cell.setAttribute("scope","col");
				thead_cell.innerText = head_name_arr[key];
		}
			var thead_cell = thead_row.appendChild(document.createElement("th"));
				thead_cell.setAttribute("scope","col");
			var edit_btn = document.createElement('button');
				edit_btn.className = "badge btn btn-success my-2 my-sm-0 w-100";
				edit_btn.dataset.id = "new";
				edit_btn.innerText = 'New';
				thead_cell.appendChild(edit_btn);

		var tbody = table.createTBody();
		
		for (var key in data) {

			var tbody_row = tbody.insertRow();
			
			for(var inner_key in data[key]){
				if(inner_key == "password" || inner_key == "photo"){ continue; }
				var tbody_cell = tbody_row.insertCell();
				tbody_cell.innerText = data[key][inner_key];
			}

			var tbody_cell = tbody_row.insertCell();

				var edit_btn = document.createElement('button');
					edit_btn.dataset.id = key;
					edit_btn.className = "badge btn btn-outline-info my-2 my-sm-0 w-50";
					edit_btn.innerText = 'Edit';
				tbody_cell.appendChild(edit_btn);

				var edit_btn = document.createElement('button');
					edit_btn.dataset.id = key;
					edit_btn.className = "badge btn btn-outline-danger my-2 my-sm-0 w-50";
					edit_btn.innerText = 'Delete';
				tbody_cell.appendChild(edit_btn);

		}

		$("#main").html(table);

	} else {

		$("#main").html(`<div class="d-flex justify-content-between"><span>Записей нет</span><button data-id="new" class="badge btn btn-success my-2 my-sm-0">New</button></div>`);

	}
}

