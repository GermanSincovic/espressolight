		<script src="../js/jquery.min.js"></script>
		<script src="../js/popper.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<script src="../js/data_workshop.js"></script>
		<script src="../js/table_drawer.js"></script>
		<script src="../js/main.js"></script>
		<script type="text/javascript">
		$("#logout").on('click', function(){
			$.ajax({
	            url: "/api/auth/logout",
	            type: "POST",
	    		dataType: "json",
	            success: function(){
					window.location.href = "/";
				}
	        });
		});
	</script>
	</body>
</html>