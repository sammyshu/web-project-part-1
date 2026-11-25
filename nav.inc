<nav class="navbar">
    <img src="images/logo.png" alt="logo" width="100">
<?php

$this_page = basename($_SERVER['SCRIPT_NAME']);

if (session_status() === PHP_SESSION_NONE)
    session_start();
$logged_in = isset($_SESSION['login']) && $_SESSION['login'] !== '';
$nav_links = array(
    'index.php' => 'Home',
    'jobs.php'  => 'Jobs',
    'apply.php' => 'Apply',
    'about.php' => 'About',
    $logged_in ? 'logout.php' : 'login.php' => $logged_in ? 'Logout' : 'Login'
    
);

foreach ($nav_links as $file => $label) {
    if ($file === $this_page) {
        echo '<a href="' . $file . '" aria-current="page">' . $label . '</a>';
    } else {
        echo '<a href="' . $file . '">' . $label . '</a>';
    }
}
?>
    <form class="searchbar" action="jobs.php" method="get">
        <!--The label is for screenreaders only because the background image (a search icon) and placeholder text already indicate the purpose of the field.-->
        <label for="search" class="for-screenreader">Search bar</label>
        <input type="text" id="search" name="search" placeholder="Search for something..." />
        <label for="go" class="for-screenreader">Submit Search</label>
        <input type="submit" id ="go" value="Go"/>
    </form>
</nav>
