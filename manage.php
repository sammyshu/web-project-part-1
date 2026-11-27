<?php

/*I use "expressions of interest" instead of "applications" throughout this file. Sounds clunky. I assume it's an Australian thing.*/
session_start();
require_once 'settings.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] != 'manager' || $_SESSION['login'] == '')
{
    header('Location: login.php');
    exit;
}

function h($val)
{
    /*Just helps shorten output validation*/
    return htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
}

$message = '';

if (isset($_POST['action']))
{
    $message = 'That action was not recognised.';

    $conn = mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
    if (!$conn)
    {
        $message = 'ERROR: Could not reach the database. Try checking that XAAMPs Mariadb is running.';
        $db_errors[] = "Database connection failed in " . __FILE__ . ": " .  mysqli_connect_error();
    }
    else
    {
        if ($_POST['action'] === 'delete')
        {
            $job_ref_in_eoi = isset($_POST['job_ref']) ? trim($_POST['job_ref']) : '';
            if (isset($_POST['job_ref']) && $job_ref_in_eoi != '')
            {
                $stmt = mysqli_prepare($conn, 'DELETE FROM eoi WHERE job_ref = ?');
                if ($stmt)
                {
                    mysqli_stmt_bind_param($stmt, 's', $job_ref_in_eoi);
                    mysqli_stmt_execute($stmt);
                    $message = mysqli_stmt_affected_rows($stmt) > 0 ? 'Deleted expressions of interest for ' . $job_ref_in_eoi . '.' : 'No expressions of interest found for ' . $job_ref_in_eoi . '.';
                    mysqli_stmt_close($stmt);
                }
                else
                {
                    $message = 'ERROR: Could not read the eoi table. Try importing eoi.sql or rerunning process_eoi.php.';
                    $db_errors[] = mysqli_error($conn);
                }
            }
            else
            {
                $message = 'Enter a job reference number to delete.';
            }
        }
        elseif ($_POST['action'] === 'status')
        {
            $id = isset($_POST['EOInumber']) ? (int) $_POST['EOInumber'] : 0;
            $status = isset($_POST['status']) ? trim($_POST['status']) : '';
            if ((strtolower($status) === "new" || strtolower($status) === "current" || strtolower($status) === "final") && $id > 0)
            {
                $stmt = mysqli_prepare($conn, 'UPDATE eoi SET status = ? WHERE EOInumber = ?');
                if ($stmt)
                {
                    $status = ucfirst(strtolower($status)); 
                    mysqli_stmt_bind_param($stmt, 'si', $status, $id);
                    mysqli_stmt_execute($stmt);
                    $message = mysqli_stmt_affected_rows($stmt) > 0 ? 'Status updated to ' . $status . ' for EOI ' . $id . '.' : 'No change made.';
                    mysqli_stmt_close($stmt);
                }
                else
                {
                    $message = 'ERROR: Could not read the eoi table. Try importing eoi.sql or rerunning process_eoi.php.';
                    $db_errors[] = mysqli_error($conn);
                }
            }
            else
            {
                $message = 'Status must be New, Current, or Final.';
            }
        }
        mysqli_close($conn);
    }

    header('Location: manage.php?msg=' . urlencode($message));
    exit;
}

/*For the table*/
$data = array();

$type_of_search_query = isset($_GET['type']) ? $_GET['type'] : 'all';

$search_term = isset($_GET['search_term']) ? trim($_GET['search_term']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'EOInumber';

/*
$types_of_search_query = array(
'ref' => 'job_ref',
''=> '',

);
*/

if ($type_of_search_query !== 'ref' && $type_of_search_query !== 'name')
{
    $type_of_search_query = 'all';
}

$sort_fields = array(
    'EOInumber' => 'EOI number',
    'job_ref' => 'Job reference',
    'first_name' => 'First name',
    'last_name' => 'Last name',
    'status' => 'Status'
);

if (!isset($sort_fields, $sort))
{
    $message = 'ERROR: Invalid sort. Sorting by ' . array_key_first($sort_fields) . '.';
    $sort = array_key_first($sort_fields);
}

$conn = mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
if (!$conn)
{
    $message = 'ERROR: Could not reach the database. Try running/re-running XAAMP or changing db_name in settings.php.';

    $db_errors[] = "Database connection failed in " . __FILE__ . ": " .  mysqli_connect_error();
}
else
{
    $columns = 'EOInumber, job_ref, first_name, last_name, email, phone, status';
    $result = false;

    if ($type_of_search_query === 'ref' && $search_term !== '')
    {
        $stmt = mysqli_prepare($conn, "SELECT $columns FROM eoi WHERE job_ref = ? ORDER BY $sort");
        if ($stmt)
        {
            mysqli_stmt_bind_param($stmt, 's', $search_term);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
        }
    }
    elseif ($type_of_search_query === 'name' && $search_term !== '')
    {
        $names = preg_split('/\s+/', $search_term); /*ther e no .split like python you have to use regex OF COURSE.. or could just..., do it another way... too late*/
        if (count($names) >= 2)
        {
            $first = '%' . $names[0] . '%';
            $last = '%' . $names[count($names) - 1] . '%';
            $stmt = mysqli_prepare($conn, "SELECT $columns FROM eoi WHERE first_name LIKE ? AND last_name LIKE ? ORDER BY $sort");
            $params = array($first, $last);
        }
        else
        {
            $whole_name = '%' . $search_term . '%';

            $stmt = mysqli_prepare($conn, "SELECT $columns FROM eoi WHERE first_name LIKE ? OR last_name LIKE ? ORDER BY $sort");
            $params = array($whole_name, $whole_name);
        }
        if ($stmt)
        {
            mysqli_stmt_bind_param($stmt, 'ss', $params[0], $params[1]);
            mysqli_stmt_execute($stmt);


            $result = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
        }
    }
    else
    {
        $result = mysqli_query($conn, "SELECT $columns FROM eoi ORDER BY $sort");
    }

    if ($result === false)
    {
        $message = 'ERROR: Could not read the eoi table. Check that XAAMPs MariaDB is running and the eoi SQL has been imported.';
        $db_errors[] = mysqli_error($conn);
    }
    else
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            $data[] = $row;
        }
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Manage page for MatchFit Sports Expressions of Interest" />
    <link rel="stylesheet" href="styles/style.css">
    <title>Manage expressions of interest | MatchFit Sports</title>

    <style>
    </style>
</head>

<body>

    <?php require_once __DIR__ . '/header.inc'; ?>
    <main>
        <div class="container">
            <h1>Manage expressions of interest</h1>
            <p>Signed in as <?= h($_SESSION['user']) ?>.
                <a href="logout.php">Sign out</a>
            </p>

            <?php 
            if (isset($_GET['msg'])){
                $beginning_p = str_starts_with($_GET['msg'], 'ERROR: ') ? '<p class="error" role="alert">' : '<p role="status">' ;
                echo $beginning_p . h($_GET['msg']) . '</p>';
            }
            ?>

            <section aria-labelledby="view-eoi-heading">
                <h2 id="view-eoi-heading">View expressions of interest</h2>
                <form class="apply-form" method="get" action="manage.php">
                    <fieldset class="form-field form-field--full">
                        <legend>Filter expressions of interest</legend>
                        <div class="choice-group">
                             <label><input type="radio" name="type" value="all" <?= $type_of_search_query === 'all' ? 'checked' : '' ?>> All applications</label>
                            <!-- I think that input in label -> worse accessibility than seperate label/input. We may change this based on the results of Part 1. -->
                            <label><input type="radio" name="type" value="ref" <?= $type_of_search_query === 'ref' ? 'checked' : '' ?>> By job reference number</label>
                            <!-- NOTE: Tried php foreach for arbitray adding seachquery types, logic too complex at first, maybe try later -->
                            <label><input type="radio" name="type" value="name" <?= $type_of_search_query === 'name' ? 'checked' : '' ?>> By applicant name</label>
                        </div>
                    </fieldset>
                    <div class="form-field form-field--full">
                        <label for="search_term">Search term:</label>
                        <input type="text" id="search_term" name="search_term" value="<?= h($search_term) ?>" placeholder="FE204 or Sammy">
                    </div>
                    <div class="form-field form-field--full">
                        <label for="sort">Sort results by:</label>
                        <select id="sort" name="sort">
                            <?php foreach ($sort_fields as $field => $label): ?>
                                <option value="<?= $field ?>" <?= $sort === $field ? 'selected' : '' ?>><?= $label ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-actions">
                        <button class="btn-primary" type="submit">Run query</button>
                        <a href="manage.php">Clear filter</a>
                    </div>
                </form>
            </section>

            <section aria-labelledby="results-heading">
                <h2 id="results-heading">Results (<?= count($data) ?>)</h2>
                <?php if ($message !== ''): ?>
                    <p class="error" role="alert"><?= h($message) ?></p>
                <?php elseif (!$data): ?>
                    <p>No expressions of interest found.</p>
                <?php else: ?>
                    <div class="table-scroll">
                        <table class="data-table">
                            <caption>Expressions of interest matching the current filter</caption>
                            <thead>
                                <tr>
                                    <th scope="col">EOI Number</th>
                                    <th scope="col">Job reference</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $row): ?>
                                    <tr>
                                        <th scope="row"><?= (int)$row['EOInumber'] ?></th>
                                        <td><?= h($row['job_ref']) ?></td>
                                        <td><?= h($row['first_name'] . ' ' . $row['last_name']) ?></td>
                                        <td><?= h($row['email']) ?></td>
                                        <td><?= h($row['phone']) ?></td>
                                        <td><?= h($row['status']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </section>

            <section aria-labelledby="status-heading">
                <h2 id="status-heading">Change an expression of interest's status</h2>
                <form class="apply-form" method="post" action="manage.php">
                    <div class="form-field">
                        <label for="eoi-number">EOI number</label>
                        <input type="text" id="eoi-number" name="EOInumber" required>
                    </div>
                    <div class="form-field">
                        <label for="status">New status</label>
                        <select id="status" name="status">
                            <option value="New">New</option>
                            <option value="Current">Current</option>
                            <option value="Final">Final</option>
                        </select>
                    </div>
                    <div class="form-actions">
                        <button class="btn-primary" name="action" value = "status" type="submit">Save status</button>
                    </div>
                </form>
            </section>

            <section aria-labelledby="deleting-heading">
                <h2 id="deleting-heading">Delete by job reference</h2>
                <form class="apply-form" method="post" action="manage.php">
                    <div class="form-field form-field--full">
                        <label for="delete-ref">Job reference number</label>
                        <input type="text" id="delete-ref" name="job_ref" required maxlength="5" placeholder="FE204">
                    </div>
                    <div class="form-actions">
                        <button class="btn-primary" name="action" value = "delete" type="submit">Delete </button>
                    </div>
                </form>
            </section>
        </div>
    </main>
    <?php require __DIR__ . '/footer.inc'; ?>
</body>
</html>

