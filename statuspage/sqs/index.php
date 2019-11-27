<?php
$mysqli = new mysqli('18.204.45.71', 'adminDBAccuMed', 'Medical9399!', 'live_queue');

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$query = 'SELECT request_id, status, b.name, action, created_on, updated_on FROM message
    JOIN intranet_live.employees b ON employee_id = b.employeeID
    ORDER BY updated_on DESC LIMIT 30';
$result = $mysqli->query($query);

while($row = $result->fetch_array())
{
$rows[] = $row;
}

/* free result set */
$result->close();

$query = 'SELECT COUNT(*) FROM (SELECT * FROM message ORDER BY updated_on DESC LIMIT 30) as a WHERE status = "success"';
$result = $mysqli->query($query);
$success = $result->fetch_row()[0];
/* free result set */
$result->close();

$query = 'SELECT COUNT(*) FROM (SELECT * FROM message ORDER BY updated_on DESC LIMIT 30) as a WHERE status = "failed"';
$result = $mysqli->query($query);
$failed = $result->fetch_row()[0];
/* free result set */
$result->close();

$query = 'SELECT COUNT(*) FROM (SELECT * FROM message ORDER BY updated_on DESC LIMIT 30) as a WHERE status = "processing"';
$result = $mysqli->query($query);
$processing = $result->fetch_row()[0];
/* free result set */
$result->close();

$query = 'SELECT COUNT(*) FROM (SELECT * FROM message ORDER BY updated_on DESC LIMIT 30) as a WHERE status = "in-queue"';
$result = $mysqli->query($query);
$in_queue = $result->fetch_row()[0];
/* free result set */
$result->close();


/* close connection */
$mysqli->close();
?>

<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css" integrity="sha384-SI27wrMjH3ZZ89r4o+fGIJtnzkAnFs3E4qz9DIYioCQ5l9Rd/7UAa8DHcaL8jkWt" crossorigin="anonymous">
        <meta http-equiv="refresh" content="10">
        <title>AccuMed SQS Monitor</title>
    </head>
    <body>
        <div class="container">
            <h3 class="mt-5">
              Async Queue
              <small class="text-muted">(last 30 tasks, updates automatically every 10 sec)</small>
            </h3>
            <a href=".">[refresh now]</a>
            <table class="table table-borderless mt-4">
                <tr>
                <td class="bg-info">In queue: <?= $in_queue ?></td>
                <td class="bg-info">Processing: <?= $processing ?></td>
                <td class="bg-success">Success: <?= $success ?></td>
                <td class="bg-danger">Failed: <?= $failed ?></td>
                </tr>
            </table>
            <table class="table table-bordered table-hover">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">Request ID</th>
                  <th scope="col">Employee</th>
                  <th scope="col">Action</th>
                  <th scope="col">Created On</th>
                  <th scope="col">Updated On</th>
                  <th scope="col">Status</th>
                </tr>
              </thead>
              <tbody>
                  <?php
                      foreach($rows as $row)
                      {
                          switch ($row['status']) {
                              case 'in-queue':
                                  $class = 'bg-info';
                                  break;
                              case 'processing':
                                  $class = 'bg-info';
                                  break;
                              case 'failed':
                                  $class = 'bg-danger';
                                  break;
                              case 'success':
                                  $class = 'bg-success';
                                  break;
                          }
                  ?>
                <tr>
                  <th scope="row"><a target="_blank" href="https://viv.accumedintel.net/request/<?= $row['request_id'] ?>"><?= $row['request_id'] ?></a></th>
                  <td><?= $row['name'] ?></td>
                  <td><?= $row['action'] ?></td>
                  <td><?= $row['created_on'] ?></td>
                  <td><?= $row['updated_on'] ?></td>
                  <td class="<?= $class ?>"><?= $row['status'] ?></td>
                </tr>
                <?php
                    }
                ?>
              </tbody>
            </table>
        </div>


        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js" integrity="sha384-3qaqj0lc6sV/qpzrc1N5DC6i1VRn/HyX4qdPaiEFbn54VjQBEU341pvjz7Dv3n6P" crossorigin="anonymous"></script>
    </body>
</html>
