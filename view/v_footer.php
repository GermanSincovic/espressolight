		<?new JS_MODEL_LOADER();?>
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