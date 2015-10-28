<?php
	function check_email($email) {
		$regex = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
		if (preg_match($regex,$email)) {
			return true;
		} else {
			return false;
		}
	}
	class pgContent {
		var $pTitle = "Home";
		var $pURL = "home.php";
		var $pIdx = 0;
		var $pUser = "N";
		var $mnuTitle = array();
		var $conPageTitle = array();
		var $conURL = array();
		var $conFunction = array();
		var $conUser = array();
		var $mStyle = 1;
		var $bgColor = "#000000";
		
		function load_menu() {
			$this->mnuTitle = array("Home");
			$this->conPageTitle = array("Home");
			$this->conURL = array("home.php");
			$this->conFunction = array(NULL);
			$this->conUser = array("N");
			$mnudb = new mSQL;
			if (isset($_SESSION['logged']) and $_SESSION['logged']->authentication == "Successful") {
				if ($_SESSION['logged']->raccess == "Y") {
					$whr = "active='Y'";
				} else {
					$whr = "active='Y' AND restricted='N'";
				}
			} else {
				$whr = "active='Y' AND useronly='N'";
			}
			$itms = $mnudb->selectQ("menu_items","*",$whr,"Idx ASC");
			foreach ($itms as $item) {
				array_push($this->mnuTitle, $item["menutitle"]);
				array_push($this->conPageTitle, $item["pagetitle"]);
				array_push($this->conURL, $item["pageURL"]);
				array_push($this->conFunction, $item["pFunction"]);
				array_push($this->conUser, $item["useronly"]);
			}
		}
		function load_index() {
			$rtn_value = array(array("Home Page","N","N","0"));
			$myDB = new mSQL;
			$itms = $myDB->selectQ("menu_items","*","active='Y'","Idx ASC");
			foreach ($itms as $item) {
				$i = -1;
				for ($x = 1; $x < count($this->conURL); $x++) {
					if ($this->conURL[$x] == $item["pageURL"]) $i = $x;
				}
				array_push($rtn_value,array($item["pagetitle"],$item["useronly"],$item["restricted"],$i));
			}
			return $rtn_value;
		}
		function load_style($style) {
			$this->mStyle = $style;
			switch ($style) {
				case "1":
					$this->bgColor = "#000000";
					break;
				case "2":
					$this->bgColor = "#984005";
					break;
				case "3":
					$this->bgColor = "#435317";
					break;
				case "4":
					$this->bgColor = "#A91D43";
					break;
				case "5":
					$this->bgColor = "#494994";
					break;
			}
		}
		function PageProcess($p) {
			if ($p == "login") {
				if (!isset($_SESSION['logged'])) {
					$_SESSION['logged'] = new LoginBox;
				}
				$_SESSION['logged']->login_process();
				$this->pIdx = 999;
				switch($_SESSION['logged']->authentication) {
					case "LogIn":
						$this->pTitle = $_SESSION['logged']->logtitle;
						$this->pURL = "LogInFrm.php";
						break;
					case "Register":
						$this->pTitle = "Register New User";
						$this->pURL = "LogInFrm.php";
						break;
					case "Failed":
						$this->pTitle = $_SESSION['logged']->logtitle;
						$this->pURL = "LogInFrm.php";
						break;
					case "Successful":
						$this->pTitle = "Welcome ".$_SESSION['logged']->uname;
						$this->pURL = "LogInFrm.php";
						break;
				}

			} elseif ($p == "logout") {
				unset($_SESSION['logged']);
				$this->load_menu();
				$this->load_style(1);
				if ($this->pUser == "Y") {
					$this->pIdx = 0;
					$this->pTitle = "Home Page";
					$this->pURL = "home.php";
				}
			} elseif ($p == "siteindex") {
				$this->pIdx = "siteindex";
				$this->pURL = "site-map.php";
				$this->pTitle = "Site Map";
			} else {
				if (isset($_SESSION['logged']) and $_SESSION['logged']->authentication <> "Successful") {
					unset($_SESSION['logged']);
				}
				if ($p <> 99) {
					if (!is_null($this->conFunction[$p])) {
						$this->conFunction[$p]();
					}
					$this->pTitle = $this->conPageTitle[$p];
					$this->pURL = $this->conURL[$p];
					$this->pIdx = $p;
					$this->pUser = $this->conUser[$p];
					if (isset($_SESSION['mySlides']) and $this->pURL <> "slide-show.php") {
						unset ($_SESSION['mySlides']);
					}
				} else {
					if (isset($_REQUEST['l']) and $_REQUEST['l'] == "Save Changes") {
						$_SESSION['logged']->UpdateUserInfo($_POST['fname'],$_POST['pword1'],$_POST['pword2'],$_POST['email'],$_POST['hphone'],$_POST['aphone'],$_POST['addr1'],$_POST['addr2'],$_POST['city'],$_POST['state'],$_POST['zip'],$_POST['mstyle']);
						$_SESSION['logged']->uname = $_POST['fname'];
					} else {
						echo "Form processing error";
					}
				}
			}
		}
	}
	class LoginBox {
		var $logtitle = "Log In";
		var $usertxt = "User Name";
		var $passtxt = "Password";
		var $btntxt = "Submit";
		var $newtxt = "Create New User";
		var $uname;
		var $user;
		var $pass;
		var $raccess;
		var $uwoeid;
		var $authenticated = False;
		var $authentication = "LogIn";
		var $successfulMSG = "You have successfully Logged In";
		var $failedMSG = "Your User Name and/or Password are incorrect";
		var $logoutMSG = "You are now Logged Out";
		
		function login_process() {
			if ($this->authentication == "LogIn") {
				if (isset($_POST["l"])) {
					if ($_POST["l"] == $this->btntxt) {
						$this->AuthLogin();
					} else if ($_POST["l"] == $this->newtxt) {
						$this->authentication = "Register";
					}
				}
			} else if ($this->authentication == "Register") {
				if (isset($_POST["s"])) {
					if ($_POST["s"] == "Register") {
						if ($_POST['fname'] <> "") {
							$this->uname = $_POST['fname'];
							if ($_POST['user'] <> "") {
								$user = new mSQL;
								$luser = $user->selectQ("users","*","username='".$_POST['user']."'","");
								if ($luser[0]['username'] <> $_POST['user']) {
									$this->user = $_POST['user'];
									if ($_POST['pword1'] <> "") {
										if ($_POST['pword1'] == $_POST['pword2']) {
											$this->pass = $_POST['pword1'];
											$luser = $user->insertQ("users",array("fullname","username","password","restricted","bcolor","fcolor","font","link","visited","mnuschema"),array($this->uname,$this->user,$this->pass,"N","black","white","sans-serif","white","yellow","1"));
											if ($luser) {
												$this->uwoeid = NULL;
												$this->raccess = "N";
												$this->authentication = "Successful";
												$_SESSION['myContent']->load_menu();
											} else {
												$_SESSION['registrywarning'] = "Error when adding user to database";
											}
										} else {
											$_SESSION['registrywarning'] = "Password and Confirmed Password do not match";
										}
									} else {
										$_SESSION['registrywarning'] = "Password must not be left blank";
									}
								} else {
									$_SESSION['registrywarning'] = "User Name already in use. Please choose another.";
								}
							} else {
								$_SESSION['registrywarning'] = "User Name must not be left blank";
							}
						} else {
							$_SESSION['registrywarning'] = "Full Name must not be left blank";
						}
					} else {
						$this->authentication = "LogIn";
					}
				}
			} else {
				$_SESSION["mnuLogIn"] = "Log In";
				$_SESSION['msgpagemsg'] = $this->logoutMSG;
				session_destroy();
				return "LoadLogin";
			}
		}
		function AuthLogin() {
			if (isset($_POST['user'])) {
				$this->user = $_POST['user'];
				$this->pass = $_POST['pword'];
				$this->authenticated = True;
				$user = new mSQL;
				$luser = $user->selectQ("users","*","username='".$this->user."'","");
				if (isset($luser[0]["username"]) AND $luser[0]["username"] == $this->user AND $luser[0]["password"] == $this->pass) {
					$this->uname = $luser[0]["fullname"];
					$this->raccess = $luser[0]["restricted"];
					$this->uwoeid = $luser[0]["user_woeid"];
					$this->authentication = "Successful";
					$_SESSION['myContent']->load_menu();
					$_SESSION['myContent']->load_style($luser[0]["mnuschema"]);
				} else {
					$this->authentication = "Failed";
					session_destroy();
				}
			} else {
				$this->authentication = "LogIn";
			}
		}
		function UpdateUserInfo($fullname,$pass1,$pass2,$email,$hphone,$aphone,$addr1,$addr2,$city,$state,$zip,$mstyle) {
			$user = new mSQL;
			if ($pass1 <> "") {
				if ($pass1 == $pass2) {
					$luser = $user->updateQ("users","username='".$this->user."'",array("password"),array($pass1));
				} else {
					$_SESSION['usermsg'] = "Passwords do not match, unable to save new password.";
				}
			}
			$luser = $user->updateQ("users","username='".$this->user."'",array("fullname","email","homephone","altphone","address1","address2","city","state","zip","mnuschema"),array($fullname,$email,$hphone,$aphone,$addr1,$addr2,$city,$state,$zip,$mstyle));
			if (!isset($_SESSION['usermsg']) and $luser) {
				$_SESSION['myContent']->load_style($mstyle);
				$_SESSION['usermsg'] = "Changes Saved Successfully";
			}
		}
	}
	class forum_discussion {
		var $T;
		var $P;
		var $C;
		
		function loadTopics() {
			$fdata = new mSQL;
			return $fdata->selectQ("forum","*","parent = '0'","ID ASC");
		}
		function setVar($top,$pst) {
			$this->P = $top;
			$this->C = $pst;
			$fdata = new mSQL;
			$topic = $fdata->selectQ("forum","*","ID = '".$top."'","");
			$this->T = $topic[0]['posttext'];
		}
		function loadPosts($topic) {
			$fdata = new mSQL;
			return $fdata->selectQ("forum","*","parent = '".$topic."'","postdate DESC");
		}
		function postCount($topic) {
			$fdata = new mSQL;
			$posts = $fdata->selectQ("forum","*","parent = '".$topic."'","");
			if ($posts) {
				return count($posts);
			} else {
				return 0;
			}
		}
		function loadComments($post) {
			$fdata = new mSQL;
			return $fdata->selectQ("forum","*","parent = '".$post."'","postdate DESC");
		}
		function commentCount($post) {
			$fdata = new mSQL;
			$comments = $fdata->selectQ("forum","*","parent = '".$post."'","");
			if ($comments) {
				return count($comments);
			} else {
				return 0;
			}
		}
		function SavePost($sub,$bdy) {
			$fdata = new mSQL;
			return $fdata->insertQ("forum",array("parent","user","subject","postdate","posttext"),array($this->P,$_SESSION['logged']->user,$sub,date("Y-m-d H:i:s"),$bdy));
		}
		function SaveComment($bdy) {
			$fdata = new mSQL;
			return $fdata->insertQ("forum",array("parent","user","subject","postdate","posttext"),array($this->C,$_SESSION['logged']->user,"",date("Y-m-d H:i:s"),$bdy));
		}
	}
	class mSQL {
		private $server = "*****";
		private $user = "*****";
		private $pass = "*****";
		private $database = "*****";
		
		function __construct() {
			try {
				$db = @mysql_connect ($this->server,$this->user,$this->pass);
				if (!$db)
					throw new dbConnectException();
				$ds = @mysql_select_db ($this->database);
				if (!$ds)
					throw new dbSelectException();
			} catch (dbConnectionException $foe) {
				echo "Error occured during database connection";
			} catch (dbSelectException $foe) {
				echo "Error occured during database selection";
			}
		}
		function insertQ($table, $fields, $fielddata) {
			try {
				if (count($fields) <> count($fielddata))
					throw new dbQFormatException();
				$a = $fields[0];
				$b = "'".addslashes($fielddata[0])."'";
				for ($x = 1; $x <= count($fields)-1; $x++) {
					$a = $a.", ".$fields[$x];
					$b = $b.", '".addslashes($fielddata[$x])."'";
				}
				$query = "INSERT INTO ".$table." (".$a.") VALUES (".$b.")";
				$result = mysql_query($query);
				return $result;
			} catch (dbQFormatException $foe) {
				echo "Error in Insert Query Format";
			}
		}
		function updateQ($table, $where, $fields, $fielddata) {
			try {
				if (count($fields) <> count($fielddata))
					throw new dbQFormatException();
				$query = "UPDATE ".$table." SET ".$fields[0]."='".addslashes($fielddata[0])."'";
				for ($x = 1; $x <= count($fields)-1; $x++) {
					$query = $query.", ".$fields[$x]."='".addslashes($fielddata[$x])."'";
				}
				$query = $query." WHERE ".$where;
				$result = mysql_query($query);
				return $result;
			} catch (dbQFormatException $foe) {
				echo "Error in Update Query Format";
			}
		}
		function selectQ($table, $fields="*", $where, $order) {
			$query = "SELECT ".$fields." FROM ".$table;
			if ($where <> "") {
				$query = $query." WHERE ".$where;
			}
			if ($order <> "") {
				$query = $query." ORDER BY ".$order;
			}
			$result = mysql_query($query);
			if (mysql_num_rows($result) == 0) {
				return False;
			} else {
				$x = 0;
				while($row=mysql_fetch_array($result)) {
					$myResults[$x] = $row;
					$x++;
				}
				return $myResults;
			}
		}
	}
	class slideshow_images {
		var $images = array();
		var $current_img = 0;
		var $show_on = False;
		
		function __construct() {
			$imgDB = new mSQL;
			$this->images = $imgDB->selectQ("slides","*","","");
			shuffle($this->images);
		}
	}
	class yahoo_weather {
		var $default_woeid = "2471390";
		var $woeid;
		var $title;
		var $weather_data;		
		
		function get_woeid($location) {
			$xml_URL = "http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20geo.places%20where%20text%3D%22".urlencode($location)."%22&format=xml";
			$feed = simplexml_load_file($xml_URL);
			$loc_results = array();
			$place = $feed->results->place;
			for ($x = 0; $x < sizeof($place); $x++) {
				$type = $place[$x]->placeTypeName;
				if ($type == "Town" or $type == "Zip Code") {
					$a = array($place[$x]->name,$place[$x]->admin1,$place[$x]->country,$place[$x]->woeid);
					array_push($loc_results,$a);
				}
			}
			return $loc_results;
		}
		function get_weather($wid) {
			$xml_URL = "http://weather.yahooapis.com/forecastrss?w=".$wid."&u=f";
			$feed = simplexml_load_file($xml_URL);
			$weather = $feed->channel;
			$this->woeid = $wid;
			$this->title = $weather->title;
			$this->weather_data = str_replace("<a href","<a target='_blank' href", $weather->item->description);
		}
	}
?>