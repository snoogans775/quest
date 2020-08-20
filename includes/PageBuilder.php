<?php

require_once('Database.php');
require_once('functions.php');

class PageBuilder
{	
	public function __construct()
	{
		$this->dom = new DOMDocument('1.0', 'utf-8');

		$database = new Database();
		$this->connection = $database->getConnection();

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
		$container->setAttribute('class', 'body-container');
		
		//Header
		$header = $this->getHeader();

		//Navbar
		$navbar = $this->getNavbar();

        //Nest the elements
		$container->appendChild($header);
		$container->appendChild($navbar);
		$dom->appendChild($container);

        return $dom;

	}
	/**
	* DOM object for header
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
   	* Create Game List for Home
	* @access private
	* @return DOMNode
   	*/
	   private function createGameList($games)
	   {
		   $dom = $this->dom;
   
		   //Navbar container
		   $container = $dom->createElement('div');
		   $container->setAttribute('class', 'gamelist-container');
   
		   //List item for each page
		   $list = $dom->createElement('ul');
		   $list->setAttribute('class', 'navbar');
   
		   foreach($pages as $page)
		   {
			   //List item for each page
			   $item = $dom->createElement('li', $page["menu_name"]);
			   $list->appendChild($item);
   
		   }
   
		   $container->appendChild($list);
   
		   return $container;
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
   	* Create NavBar DOMNode
	* @access private
	* @return DOMNode
   	*/
	private function createNavbar($pages)
	{
		$dom = $this->dom;

        //Navbar container
        $container = $dom->createElement('div');
		$container->setAttribute('class', 'navbar-container');

		//List item for each page
		$list = $dom->createElement('ul');
		$list->setAttribute('class', 'navbar');

		foreach($pages as $page)
		{
			//List item for each page
			$item = $dom->createElement('li', $page["menu_name"]);
			$list->appendChild($item);

		}

		$container->appendChild($list);

		return $container;
	}
	
	public function getHeader(String $context='public')
	{
		return $this->createHeader();
	}
	
	public function getLoginForm()
	{
		return $this->createLoginForm();
	}
	
	public function getNavbar() 
	{
		$pages = [];
		$page_set = find_all_subjects($this->connection);
		while($page = mysqli_fetch_assoc($page_set))
		{
			array_push($pages, $page);
		}

		return $this->createNavbar($pages);
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