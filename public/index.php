<?php include("../includes/header.php"); ?>
<div class="page">
	<font color="red">
	<?php echo form_errors($errors). $_SESSION["message"]; 
	$_SESSION["message"] = "";
	?>
	</font>
	<?php 
		if(isset($current_subject)) { 
			include("{$current_subject["menu_name"]}.php"); 
		} else {
			include("home.php");
		} ?>
	<?php include("../includes/footer.php"); ?>
	
</div>
</body>
</html>