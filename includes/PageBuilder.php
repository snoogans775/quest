<?php

require_once('Database.php');
require_once('functions.php');

class PageBuilder
{	
	public function __construct()
	{
		$this->dom = new DOMDocument('1.0', 'utf-8');

		$database = new Database();
		$this->connection = $database::getConnection();

		$this->root = "/quest/public/";

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

		//Gamelist
		$gamelist = $this->getGameList();

        //Nest the elements
		$container->appendChild($header);
		$container->appendChild($navbar);
		$container->appendChild($gamelist);
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
		$signup = $dom->createElement('a', 'New User?');
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
   	* HTML to render for errors.
	* @access private
	* @return DOMNode
	*/	
	private function createErrorModal() {
		'<font color="red">
		<?php # Display any form errors
			echo form_errors($errors). $_SESSION["message"]; 
			$_SESSION["message"] = "";
		?>
		</font>';
	}
		
  	/**
   	* HTML to render for logged in users.
	* @access private
	* @return DOMNode
   	*/	
	private function createGreeting() {
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
	}	
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
			$listItem = $dom->createElement('li');
			$link = $dom->createElement('a', $page["menu_name"]);
			$link->setAttribute('href', $this->root . $page["menu_name"] . '.php');
			
			$listItem->appendChild($link);
			$list->appendChild($listItem);

		}

		$container->appendChild($list);

		return $container;
	}

	//--------------GETTERS---------------//

	public function getGameList() 
	{
		$user_set = find_all_users($this->connection);

		return $this->createGameList($user_set);
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