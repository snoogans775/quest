<?php

require_once('WebElement.php');

class PageBuilder
{	
	public function __construct()
	{
		/**
		* dom object to construct elements
		* @var dom
		* @access private
		*/
		$this->dom = new DOMDocument();
	}
  	/**
   	* HTML to render fo <head>
   	* @var headerHTML
   	* @access private
   	*/
	private $header =
		'
			<head>
				<meta charset="utf-8">
				<title>The Quest</title>
				<link rel="stylesheet" href="css/style.css" type="text/css">
				<link rel="stylesheet" type="text/css"
				      href="https://fonts.googleapis.com/css?family=IM+Fell+Great+Primer|Nunito|Averia+Sans+Libre">
							<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
			</head>
		';
		
  	/**
   	* HTML to render for page banner
   	* @var banner
   	* @access private
   	*/
	private function createBanner()
	{ 
		$dom = $this->dom;

		$bannerDiv = $dom->createElement('div');
		$bannerId = $dom->createAttribute('id');
		$bannerId->value = 'banner';
		$bannerDiv->appendChild($bannerId);

		$bannerDiv = $dom->createElement('a');
		$bannerId = $dom->createAttribute('href');
		$bannerId->value = './index.php';
		$bannerDiv->appendChild($bannerId);

		$imgDiv = $dom->createElement('img');
		$imgId = $dom->createAttribute('src');
		$imgId->value = './images/quest_logo.png';
		$imgDiv->appendChild($bannerId);

		return $bannerDiv;

	}
	/**
	* HTML to render for user login.
	* @var loginForm
	* @access private
	*/
	private $loginForm = 
		'
			<div class="header">
				<div id="banner">
					<a href="index.php"><img src="../public/images/quest_logo.png"></img></a>
				</div>
				<div class="login">
					<form action="login.php" method="POST">
						<input type="text" placeholder="username" name="username" /><br />
						<input type="password" placeholder="password" name="password" /><br/>
						<span>
							<input type="submit" name="submit" value="login" />
					</form>
							<a href="new_user.php">&nbsp &nbsp New To The Quest?</a>
						</span>
				</div>
				<div class="navbar">
						<?php echo navigation($current_subject, $current_page); ?>
				</div>
			</div>
			<hr />	
		';
		
  	/**
   	* HTML to render for logged in users.
   	* @var greeting
   	* @access private
   	*/	
	private $greeting = 
		'
			<div class="header">
				<div id="banner">
					<a href="index.php"><img src="../public/images/quest_logo.png"></img></a>
				</div>
				<div class="login">
					<span id="greeting">
						Hello, <?php echo $_SESSION["username"]; ?> 
					</span>
					<span id="logout">
						<a href="logout.php">Logout</a>
					</span>
	 				<br />
					Points: 
					<?php 
						$current_user = find_user_by_id($_SESSION["user_id"]);
						echo $current_user["points"]; ?> 
					<br />
					<span id="mini_menu">
						<a href="manage_user.php?id=<?php echo $_SESSION["user_id"]; ?>">Your Quest</a>
					</span>
				</div>
			</div>
			<hr />	
		';
				
  	/**
   	* HTML to render for navigation
   	* @var navbarHTML
   	* @access private
   	*/
	private $navbar = 
		'<div class="navbar">
					<?php echo navigation($current_subject, $current_page); ?>
			</div>';
	
	public function getHeader(String $context)
	{
		return $this->header;
	}
	
	public function getBanner()
	{
		return $this->createBanner();
	}
	
	public function getLoginForm()
	{
		return $this->loginForm;
	}
	
	public function getNavbar()
	{
		return $this->navbar;
	}
	
	public function getGreeting()
	{
		return $this->greeting;
	}
}

?>