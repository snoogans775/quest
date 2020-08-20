<?php 
	include("../includes/header.php");
?>
	<div class="page">
		
		<?php 
			# Display any form errors
			echo form_errors($errors). $_SESSION["message"];
			
			# Display menu item for navigation
			if(isset($current_subject)) { 
				include("{$current_subject["menu_name"]}.php"); 
			} else {
				include("home.php");
			}
		?>
	<?php
		include("../includes/footer.php"); 
	?>
	
	</div>
</body>
</html>