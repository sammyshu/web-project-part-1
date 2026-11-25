<?php


$db_host = 'localhost';
$db_user = 'root';
$db_pwd = '';  
$db_name = 'matchfit';
if (!isset($db_errors))
    $db_errors = array(); 

function connect_xampp(){
    

/*MUST CLOSE CONN!!!!*/
    global $db_host, $db_user, $db_pwd, $db_errors;
    try
    {
        $conn = mysqli_connect($db_host, $db_user, $db_pwd);
        return $conn;
    } 
    catch(mysqli_sql_exception $e){
        $db_errors[] = $e->getMessage();

        return false;
    }
}

function execute_sql_file($file_path_relative, $this_file){
    /*

    This is for executing sql files that set up databases or tables

    To use:
    $file_path_relative is relative to the file calling the function. So if i wanted to declare jobs.sql from jobs.php

    In jobs.php:
    $this_file = __FILE__
    $file_path_relative = /sql/jobs.sql
    */
    global $db_errors;
    $conn = connect_xampp();
    if ($conn == false)
    {
        die("connect_xammp failed."); /*I send a vague error message for security because who knows what info the exception contains*/
    }
    $dir = dirname($this_file);

    $multi_query = file_get_contents($dir. $file_path_relative);

    if (mysqli_multi_query($conn, $multi_query)) {
        while (mysqli_more_results($conn)) 
        {
            mysqli_next_result($conn);
        }
} 
else 
{
    echo '<p class="error" role="alert">' . htmlspecialchars(mysqli_error($conn), ENT_QUOTES, 'UTF-8') . '</p>';
}
mysqli_close($conn);
}


function create_db()
{
try{
execute_sql_file("/sql/matchfit.sql", __FILE__); /*Surprisingly, this doesn't cause problems 
                                                     with running on Windows vs Linux.
                                                     PHP translates forward-slashes to the appropriate directory seperator 
                                                     based on the operating system. */
}catch(mysqli_sql_exception $e){
    $db_errors[] = $e->getMessage();
    return false;
}
}

create_db(); /*So that matchfit db ALWAYS exists before anyone tries to insert in it.*/