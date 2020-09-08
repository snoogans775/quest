<br />
<div class="footer">
<?php
	if (isset($result)) {
	//release returned data
	mysqli_free_result($result);
	//closes database connection
	mysqli_close($connection);
	}
?>
	<p> Copyright <?php echo strftime("%Y", time()) ?> | RVGS R&D</p>
	<ul>
		<li><a href="http://www.rvgsymphony.com">Reno Video Game Symphony</a></li>
		<li><a href="mailto:kfrednv@gmail.com">Contact Kevin for technical problems</a></li>
	</ul>
</div>
</body>
	</html>