<?php

class PageBuilder
{	
	public function __construct()
	{
		$this->dom = new DOMDocument('1.0', 'utf-8');
	}
	/**
	* DOM object for page header
	*
	* @access private
	* @return DOMNode
	*/
	private function createHeader()
	{ 
		$dom = $this->dom;

        //Masthead container
        $container = $dom->createElement('div');
        $container->setAttribute('class', 'header');

        //Banner container
        $banner = $dom->createElement('div');
        $banner->setAttribute('id', 'banner');

        //Link to home
        $link = $dom->createElement('a');
        $link->setAttribute('href', './');

        //Banner image
        $image = $dom->createElement('img');
		$image->setAttribute('src', './images/quest_logo.png');
		
		//Login
		$login = $this->createLoginForm();

        //Nest the elements
        $link->appendChild($image);
        $banner->appendChild($link);
		$container->appendChild($banner);
		$container->appendChild($login);
        $dom->appendChild($container);

        return $container;

	}
	/**
	* DOM object for home
	*
	* @access private
	* @return DOMDocument
	*/
	private function createHomepage()
	{ 
		$dom = $this->dom;

        //Body container
        $container = $dom->createElement('div');
		$container->setAttribute('id', 'body-container');
		
		//Header
		$header = $this->createHeader();

        //Nest the elements
		$container->appendChild($header);
		$dom->appendChild($container);

        return $dom;

	}
	/**
	* HTML to render for user login.
	* @access private
	* @return DOMNode
	*/
	private function createLoginForm() { 
		$dom = $this->dom;

        //Body container
        $container = $dom->createElement('div');
		$container->setAttribute('class', 'login');
		
		//Login Form
		$form = $dom->createElement('form');
		$form->setAttribute('action', 'login.php');
		$form->setAttribute('method', 'POST');

		//Username
		$user = $dom->createElement('input');
		$user->setAttribute('type', 'text');
		$user->setAttribute('placeholder', 'username');
		$user->setAttribute('name', 'username');

		//Password
		$password = $dom->createElement('input');
		$password->setAttribute('type', 'password');
		$password->setAttribute('placeholder', 'password');
		$password->setAttribute('name', 'password');

		//Submit
		$submit = $dom->createElement('input');
		$submit->setAttribute('type', 'submit');
		$submit->setAttribute('value', 'login');
		$submit->setAttribute('name', 'submit');

		//Signup
		$signup = $dom->createElement('a');
		$signup->setAttribute('href', 'new_user.php');

        //Nest the elements
		$form->appendChild($user);
		$form->appendChild($password);
		$form->appendChild($submit);
		$container->appendChild($form);
		$container->appendChild($signup);

        return $container;
	}
		
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
	
	public function getHeader(String $context='public')
	{
		return $this->createHeader();
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
	public function getHomepage()
	{
		return $this->createHomepage();
		
	}
}

?>