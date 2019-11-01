<?
	try {
		$mysqli->query("CREATE TABLE `clients` (
	                  `id` INT NOT NULL AUTO_INCREMENT,
	                  `name` VARCHAR(250) NOT NULL,
	                  `created` TIMESTAMP NOT NULL,
	                  `active` TINYINT(1) NOT NULL,
	                  `phone` VARCHAR(50) NOT NULL,
	                  `email` VARCHAR(50) NOT NULL,
	                  `owner` VARCHAR(250) NOT NULL,
	                  PRIMARY KEY (`id`) )
	                  COLLATE='utf8_general_ci';");
	} finally {
		$result = $mysqli->query("SELECT * FROM clients");
	}
	
	// vardump($result);

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Espresso | Control panel</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	</head>
	<body>

		<nav class="navbar navbar-light bg-light">
			<a class="navbar-brand">Navbar</a>
			<a class="form-inline" href="../admin/c_logout.php">Logout</a>
		</nav>

		<div class="container-fluid">
			<div class="row justify-content-center">
				<div class="col-10">
					<table class="table">
						<thead>
							<tr>
								<th scope="col">ID</th>
								<th scope="col">Название</th>
								<th scope="col">Владелец</th>
								<th scope="col">Телефон</th>
								<th scope="col">E-mail</th>
								<th scope="col">Начало использования</th>
								<th scope="col">Активность</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th scope="row">1</th>
								<td>Brown Coffee</td>
								<td>Александр</td>
								<td>+3801112223344</td>
								<td>shtoto@gmail.com</td>
								<td>01.11.2019</td>
								<td>&#10004;</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</body>
</html>