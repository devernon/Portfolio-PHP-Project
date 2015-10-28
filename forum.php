<?php
	$myForum = new forum_discussion;
	if (!isset($_REQUEST['t'])) {
		echo "
			<span class='ftitle'>My Topics</span>
			<ul>";
		$myTopics = $myForum->loadTopics();
		foreach ($myTopics as $Topic) {
			$cCount = $myForum->postCount($Topic['ID']);
			echo "
            	<li class='ftopic'>".$Topic['posttext']."&nbsp;<i><a href='index.php?p=".$_SESSION['myContent']->pIdx."&t=".$Topic['ID']."&c=0'>(".$cCount." POSTS)</a></i></li>";
		}
		echo "
            </ul>";
	} else {
		$myForum->setVar($_REQUEST['t'], $_REQUEST['c']);
		if (isset($_REQUEST['pst']) and $_REQUEST['pst'] == "Submit") {
			if ($_REQUEST['fSubject'] == "" or $_REQUEST['fPost'] == "") {
				echo "<span class='fpstlk'><b><i>Subject and/or Body can not be blank!</a></b></span><br>";
			} else {
				if (!$myForum->SavePost($_REQUEST['fSubject'],$_REQUEST['fPost'])) {
					echo "<span class='fpstlk'<b><i>Error during save opperation";
				}
			}
		}
		if (isset($_REQUEST['cmt']) and $_REQUEST['cmt'] == "Submit") {
			if ($_REQUEST['fComment'] == "") {
				echo "<span class='fpstlk'><b><i>Comment can not be blank!</a></b></span><br>";
			} else {
				if (!$myForum->SaveComment($_REQUEST['fComment'])) {
					echo "<span class='fpstlk'<b><i>Error during save opperation";
				}
			}
		}
		if (isset($_REQUEST['a'])) {
			if ($_REQUEST['a'] == "newPost") {
				$postForm = "
                <form name='newPost' method='post' action='index.php?p=".$_SESSION['myContent']->pIdx."&t=".$myForum->P."&c=0'>
					<label class='pstform-l'><b>Subject: </b></label><input type='text' name='fSubject' size='50'><br class='clr' />
					<label class='pstform-l'><b>Post: </b></label><textarea cols='50' rows='3' name='fPost'></textarea><br class='clr' />
					<label class='pstform-l'>&nbsp;</label><input type='submit' name='pst' value='Submit'><input type='submit' name='pst' value='Cancel'>
				</form><br class='clr' />";
			} elseif ($_REQUEST['a'] == "newComment") {
				$commentForm = "
				<form name='newComment' method='post' action='index.php?p=".$_SESSION['myContent']->pIdx."&t=".$myForum->P."&c=".$myForum->C."'>
					<textarea cols='50' rows='3' name='fComment'></textarea><br>
					<input type='submit' name='cmt' value='Submit'><input type='submit' name='cmt' value='Cancel'>
				</form>";
			}
		}
		echo "
			<span class='ftitle'>".$myForum->T."</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class='frtnlk'><a href='index.php?p=".$_SESSION['myContent']->pIdx."'>Return to Topic Index</a></span><br>";
		if (isset($_SESSION['logged']) and $_SESSION['logged']->authentication == "Successful") {
			if (isset($postForm)) {
				echo $postForm;
			} elseif (!isset($commentForm)) {
				echo "&nbsp;&nbsp;&nbsp;&nbsp;<span class='fpstlk'><a href='index.php?p=".$_SESSION['myContent']->pIdx."&t=".$myForum->P."&c=0&a=newPost'>Add New Post</a></span>";
			}
		} else {
			echo "&nbsp;&nbsp;&nbsp;&nbsp;<span class='fpstlk'><i>You must be logged on in order to post and/or comment.</i></span>";
		}
		echo "
			<ul>";
		$myPosts = $myForum->loadPosts($myForum->P);
		if ($myForum->postCount($myForum->P) != 0)
		{
		  foreach ($myPosts as $Post) {
			  $cCount = $myForum->commentCount($Post['ID']);
			  if ($cCount == 0 or $myForum->C == $Post['ID'] or isset($postForm) or isset($commentForm)) {
				  $cLink = "(".$cCount." Comments)";
			  } else {
				  $cLink = "<a href='index.php?p=".$_SESSION['myContent']->pIdx."&t=".$myForum->P."&c=".$Post['ID']."'>(".$cCount." Comments)</a>";
			  }
			  echo "
				  <li><span class='fhead'>Subject: ".$Post['subject']."</span><br><span class='fdate'>Post Date: ".$Post['postdate']."</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class='fauth'>By User: ".$Post['user']."</span><br><span class='ftext'>".$Post['posttext']."</span><br><span='ffoot'>".$cLink;
			  if (isset($_SESSION['logged']) and $_SESSION['logged']->authentication == "Successful") {
				  if (isset($commentForm) and $myForum->C == $Post['ID']) {
					  echo $commentForm;
				  } elseif (!isset($postForm) and !isset($commentForm)) {
					  echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href='index.php?p=".$_SESSION['myContent']->pIdx."&t=".$myForum->P."&c=".$Post['ID']."&a=newComment'>Add Comment</a>";
				  }
			  }
			  echo "</span></li>";
			  if ($myForum->C == $Post['ID']) {
				  echo "
				  <ul>";
				  $myComments = $myForum->loadComments($myForum->C);
				  foreach ($myComments as $Comment) {
					  echo "
					  <li><span class='fdate'>Post Date: ".$Comment['postdate']."</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class='fauth'>By User: ".$Comment['user']."</span><br><span class='ftext'>".$Comment['posttext']."</span></li>";
				  }
				  echo "
				  </ul>";
			  }
		  }
		} else {
			echo "<p>This Topic currently has no Posts!</p>";	
		}
		echo "
			</ul>";
	}
?>