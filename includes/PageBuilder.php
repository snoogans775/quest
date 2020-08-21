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

<<<<<<< HEAD
=======
		$this->root = "/quest/public/";

>>>>>>> dev
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

<<<<<<< HEAD
        //Nest the elements
		$container->appendChild($header);
		$container->appendChild($navbar);
=======
		//Gamelist
		$gamelist = $this->getGameList();

        //Nest the elements
		$container->appendChild($header);
		$container->appendChild($navbar);
		$container->appendChild($gamelist);
>>>>>>> dev
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
<<<<<<< HEAD
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
=======
	private function createGameList($user_set)
	{
		$dom = $this->dom;

		//Gamelist container
		$container = $dom->createElement('div');
		$container->setAttribute('class', 'gamelist-container');

		//List item for each page
		$list = $dom->createElement('div');
		$list->setAttribute('class', 'list');

		while($user = mysqli_fetch_assoc($user_set)) {
			$currentList = find_list_by_user($this->connection, $user["id"]);

			//Create an element to hold the list of games for the user
			$userList = $dom->createElement('ul', $user["username"]);
			
			//Add an entry for every game in the currentList
			while($game = mysqli_fetch_assoc($currentList))
			{
				//Create entry
				$entry = $this->createListEntry($game);

				//Add entry to list
				$userList->appendChild($entry);
			}

			
			$list->appendChild($userList);
		}
	

		$container->appendChild($list);

		return $container;
	}

	/**
	* Node for entries in a gamelist
	* @access private
	* @param mysqliObject
	* @return DOMNode
	*/
	private function createListEntry($game) {
		$dom = $this->dom;
		
		$gameTitle = $dom->createTextNode(htmlentities($game["title"]));

		$listEntry = $dom->createElement('li');
		$listEntry->setAttribute('class', 'title');		
		
		$followLink = $dom->createElement('a');
		$followLink->setAttribute('href', 'follow_game.php?game_id="' .$game["game_id"]. '"');
		$followLink->setAttribute('onClick', 'return confirm("Follow this game?")');
		$followLinkImg = $dom->createElement('img');
		$followLinkImg->setAttribute('class', 'follow-button');
		$followLinkImg->setAttribute('src', $this->root.'images/follow_button.jpg');

		//Construct drop-down content
		$dropDown = $dom->createElement('div');
		$dropDown->setAttribute('class', 'dropdown');
		$dropDownText = $dom->createTextNode("Platform: " .htmlentities($game["platform"]));
		$dropDown->appendChild($dropDownText);

		//Construct entry
		$followLink->appendChild($followLinkImg);
		$listEntry->appendChild($gameTitle);
		$listEntry->appendChild($followLink);
		$listEntry->appendChild($dropDown);

		return $listEntry;
	}

>>>>>>> dev
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
<<<<<<< HEAD
=======

	//--------------GETTERS---------------//

	public function getGameList() 
	{
		$user_set = find_all_users($this->connection);

		return $this->createGameList($user_set);
	}
>>>>>>> dev
	
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
<<<<<<< HEAD
	public function getGameList() 
	{
		$gamelist = [];
		$user_set = find_all_users($this->connection);
		while($user = mysqli_fetch_assoc($user_set)) {
			$current_user = mysqli_fetch_assoc(find_list_by_user($user["id"]));
			if (!empty($current_user)) {
				echo $user["username"];
				echo display_list($user["id"]);
				array_push()
			}
		}

		return $this->createGameList($games);
	}
=======
>>>>>>> dev
	
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