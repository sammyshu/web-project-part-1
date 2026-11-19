<nav class="navbar">
    <img src="images/logo.png" alt="logo" width="100">
<?php
/* Highlight the link of the page the visitor is on. SCRIPT_NAME is the file
   being served (e.g. /about.php), so basename() gives "about.php" to compare
   against each link. Pages no longer need to tell the nav where they are. */
$this_page = basename($_SERVER['SCRIPT_NAME']);
$nav_links = array(
    'index.php' => 'Home',
    'jobs.php'  => 'Jobs',
    'apply.php' => 'Apply',
    'about.php' => 'About',
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
