<nav class="shadow border-rounded">
	<a class="navbar-brand">
		<img src="../img/logo.png" class="mr-3" width="50" height="50" alt="EspressoLIGHT">
		<h1>
			<i>Espresso <sub><small>light</small></sub></i>
		</h1>
	</a>
	<div id="nav-controls">
		<div class="btn" data-route="companies">Компании</div>
		<div class="btn" data-route="users">Пользователи</div>
		<div class="btn" data-route="other">Другое</div>
	</div>
	<form action="<?=DOMAIN;?>" method="POST">
		<input class="btn" type="submit" value="Выход">
		<input type="hidden" name="logout" value="1">
	</form>
</nav>