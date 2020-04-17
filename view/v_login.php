<!DOCTYPE html>
<html>
	<head>
		<title>Espresso | Авторизация</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	</head>
	<body>
		
		<div class="container-fluid">
			<div class="row justify-content-center">
				<div class="col-3">
					<form id="auth-form" class="text-center border rounded p-5" method="POST" onsubmit="return false;">
					    <p class="h4 mb-4">Авторизация</p>
					    <input type="text" id="login" name="login" class="form-control mb-4" placeholder="Логин" >
					    <input type="password" id="password" name="password" class="form-control mb-4" placeholder="Пароль" >
					    <button id="login_btn" class="btn btn-secondary btn-block my-4" type="submit">Вход</button>
					</form>
				</div>
			</div>
			<!-- Default form login -->
		</div>

		<script src="../js/jquery.min.js"></script>
		<script src="../js/popper.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<script type="module" src="../js/main.js"></script>
	</body>
</html>

