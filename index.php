<?php
require_once 'core/init.php';

if (Session::exists('home')) {
	echo '<p>' . Session::flashmsg('home') .  '</p>';
  }
  $user = new User();

  if ($user->isLoggedIn()) {
	echo "<p>Success! You are logged in!</p><br><br>";
	?>
	<p>
	  Hello <a href="#"><?php echo escape($user->data()->username); ?>"</a>
	</p>
  
	<ul>
	  <li><a href="update.php">Update</a></li>
	  <li><a href="changepassword.php">Change Password</a></li>
	  <li><a href="logout.php">Logout</a></li>
  
	</ul>
	<?php
	if ($user->hasPermission('admin')) {
	  echo "<p>You are an Administrator!</p>";
	}
  	} else {
	echo "<p>You need to <a href='login.php'>log in</a> or <a href='register.php'>register</a></p>";
  	}	