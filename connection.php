<!-- query must be pre defined in the calling script -->




<?php 
/* 
How to use:
<?php require_once __DIR__ . connection.php
$query = "SELECT some_columns FROM some_table;"
$this_file = __FILE__ 
$data = connect_to_db_and_retrieve_data($query, $this_file)

Then, $data will be an array of associative arrays. 

So, if the query returned two rows, like this:

id | name | email
1  | sam  | sam@gmail.com
2  | fam  | fam@gmail.com

then the $data will contain [['id':1, 'name':'sam', 'sam@gmail.com'], ['id':2, 'name':'fam', 'fam@gmail.com']]


?>



require_once 'settings.php';


function connect_to_db_and_retrieve_data($query, $this_file) {


    global $db_host, $db_user, $db_pwd, $db_name, $db_errors;
    $data = array();
    $conn = mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
    if ($conn)
    {
        $result = mysqli_query($conn, $query);
        if ($result) 
        {
            for ($i = 0; $i < mysqli_num_rows($result); $i++)
            {
                $onerow = mysqli_fetch_assoc($result);
                $data[] = $onerow;
            }
        } 
        else 
        {
            $db_errors[] = "Query failed in " . $this_file . ": " . mysqli_error($conn);
        }
        mysqli_close($conn);
    } 
    else 
    {
        $db_errors[] = "Database connection failed in " . $this_file . ": " . mysqli_connect_error();
    }
    return $data;
}


*/


function connect_to_db_and_retrieve_data($query, $this_file){

die("This function is deprecated because it didn't use prepared statements. Please write your own connection code. You can try and use one of my helper functions from settings.php.");

}