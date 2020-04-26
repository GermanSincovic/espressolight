<!DOCTYPE html>
<html lang="ua">
	<head>
		<title>Espresso | Control panel</title>
		<link rel="stylesheet" href="<?=DOMAIN.'css/bootstrap.min.css';?>">
	</head>
	<body class="container-fluid px-5 bg-light">

        <?include('v_header.php');?>

		<div class="g-devider"></div>

		<section id="main" class="mt-5 p-3 bg-white shadow rounded">
		</section>

		<div id="spinner" class="hidden"><span></span><span>ЗАГРУЗКА...</span></div>

        <script src="../js/jquery.min.js"></script>
        <script src="../js/popper.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
		<script type="module" src="../js/main.js"></script>
	</body>
</html>
