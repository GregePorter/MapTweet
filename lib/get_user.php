<!-- This is a basic page to get the user name of the user whose tweets you want to see -->
<title> Please enter the screen name </title>
<?php 

session_start();

if(isset($_SESSION['error'])){
	echo $_SESSION['error'];
	unset($_SESSION['error']);
}
?>
<form action="../index.php" method="GET">
    <div>
      <label for="q">Please enter the screen name of the desired user</label><br>
      <input type="text" name="q"></input>
      <br />
      <input type="submit" value="Submit" />
    </div>
</form>
