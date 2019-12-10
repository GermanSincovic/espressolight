<!DOCTYPE html>
<html>
	<head>
		<title>Espresso | Login</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	</head>
	<body>
		


		<div class="container-fluid">
			<div class="row justify-content-center">
				<div class="col-3">
					<form class="text-center border rounded p-5" action="/" method="POST">
					    <p class="h4 mb-4">Sign in</p>
					    <input type="text" name="login" class="form-control mb-4" placeholder="Login" required="required">
					    <input type="password" name="password" class="form-control mb-4" placeholder="Password" required="required">
					    <button class="btn btn-secondary btn-block my-4" type="submit">Enter</button>
					</form>
				</div>
			</div>
			<!-- Default form login -->
		</div>


		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<script type="text/javascript">
			function SendGet() {
				$.ajax({
		            url: "/api/users",
		            type: "GET",
		    		dataType: "text",
		            success: function(data){
						$("#main").html(data);

					} 
		        });
			}
		</script>
	</body>
</html>