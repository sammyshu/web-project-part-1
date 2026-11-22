<?php
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: apply.php");
    exit();
}

require_once("settings.php");
$conn = mysqli_connect($db_host, $db_user, $db_pwd, $db_name);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

function clean($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$job_ref      = clean($_POST['job_ref']);
$first_name   = clean($_POST['first_name']);
$last_name    = clean($_POST['last_name']);
$dob          = clean($_POST['dob']);
$gender       = clean($_POST['gender']);
$street       = clean($_POST['street']);
$suburb       = clean($_POST['suburb']);
$state        = clean($_POST['state']);
$postcode     = clean($_POST['postcode']);
$email        = clean($_POST['email']);
$phone        = clean($_POST['phone']);
$other_skills = clean($_POST['other_skills']);

$skills = "";
if (isset($_POST['skills'])) {
    $skills = implode(", ", $_POST['skills']);
}

$error_message = "";

if (empty($job_ref) || empty($first_name) || empty($last_name) || empty($dob) || empty($gender) || empty($street) || empty($suburb) || empty($state) || empty($postcode) || empty($email) || empty($phone) || empty($skills)) {
    $error_message .= "Please fill in all required fields.<br>";
}

if (!preg_match("/^[A-Za-z0-9]{5}$/", $job_ref)) {
    $error_message .= "Job reference must be exactly 5 letters/numbers.<br>";
}
if (!preg_match("/^[A-Za-z][A-Za-z' \-]{0,19}$/", $first_name)) {
    $error_message .= "First name can only contain letters.<br>";
}
if (!preg_match("/^[0-9]{4}$/", $postcode)) {
    $error_message .= "Postcode must be 4 digits.<br>";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error_message .= "Invalid email address.<br>";
}
if (!preg_match("/^[0-9]{8,12}$/", $phone)) {
    $error_message .= "Phone must be 8 to 12 digits.<br>";
}

$date_parts = explode("/", $dob);
if (count($date_parts) == 3) {
    $dob_for_mysql = $date_parts[2] . "-" . $date_parts[1] . "-" . $date_parts[0];
} else {
    $error_message .= "Date of birth must be dd/mm/yyyy.<br>";
    $dob_for_mysql = "";
}

if (!empty($error_message)) {
    echo "<h2>Error</h2>";
    echo "<p style='color:red;'>$error_message</p>";
    echo "<p><a href='apply.php'>Go back to the form</a></p>";
    exit();
}

$create_table_query = "CREATE TABLE IF NOT EXISTS eoi (
    EOInumber INT AUTO_INCREMENT PRIMARY KEY,
    job_ref VARCHAR(5) NOT NULL,
    first_name VARCHAR(20) NOT NULL,
    last_name VARCHAR(20) NOT NULL,
    dob DATE NOT NULL,
    gender VARCHAR(10) NOT NULL,
    street VARCHAR(40) NOT NULL,
    suburb VARCHAR(40) NOT NULL,
    state VARCHAR(3) NOT NULL,
    postcode VARCHAR(4) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(12) NOT NULL,
    skills TEXT NOT NULL,
    other_skills TEXT,
    status ENUM('New', 'Current', 'Final') DEFAULT 'New'
)";
mysqli_query($conn, $create_table_query);

$insert_query = "INSERT INTO eoi (job_ref, first_name, last_name, dob, gender, street, suburb, state, postcode, email, phone, skills, other_skills) 
                 VALUES ('$job_ref', '$first_name', '$last_name', '$dob_for_mysql', '$gender', '$street', '$suburb', '$state', '$postcode', '$email', '$phone', '$skills', '$other_skills')";

$result = mysqli_query($conn, $insert_query);

if ($result) {
    $eoi_number = mysqli_insert_id($conn);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Success</title>
        <link rel="stylesheet" href="styles/style.css">
    </head>
    <body style="text-align:center; padding: 50px; font-family: sans-serif;">
        <h1>Thank you, <?php echo $first_name; ?>!</h1>
        <p>Your Expression of Interest has been received.</p>
        <h2>Your EOI Number is: <?php echo $eoi_number; ?></h2>
        <p><a href="apply.php">Submit another application</a></p>
    </body>
    </html>
    <?php
} else {
    echo "Error saving to database: " . mysqli_error($conn);
}

mysqli_close($conn);
?>