<?php
    $path = '/mnt/dropbox/AccuMed Team Folder/Databases/Backups/Live/';
    $date = new DateTime();
    $count = 0;
    while ($count < 14) {
        $datePath = $path . $date->format('Y/m/d');
        clearstatcache();
        $backup[$count]['result'] = file_exists($datePath);
        $backup[$count]['date'] = $date->format('m/d/Y');
        $count++;
        $date = $date->sub(new DateInterval('P1D'));
    }
?>

<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css" integrity="sha384-SI27wrMjH3ZZ89r4o+fGIJtnzkAnFs3E4qz9DIYioCQ5l9Rd/7UAa8DHcaL8jkWt" crossorigin="anonymous">
        <title>AccuMed Backup Check</title>
    </head>
    <body>
        <div class="container">
            <h3 class="mt-3">
              Database Backup
              <small class="text-muted">(last 14 days)</small>
            </h3>
            <table class="table table-bordered table-hover col-md-6 mt-4">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">Date</th>
                  <th scope="col">Status</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    foreach ($backup as $row) {
                ?>
                    <tr>
                      <th scope="row"><?= $row['date'] ?></th>
                      <td class="<?= $row['result'] ? 'bg-success' : 'bg-danger' ?>"><?= $row['result'] ? 'OK' : 'Fail' ?></td>
                    </tr>
                <?php } ?>
              </tbody>
            </table>
        </div>


        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js" integrity="sha384-3qaqj0lc6sV/qpzrc1N5DC6i1VRn/HyX4qdPaiEFbn54VjQBEU341pvjz7Dv3n6P" crossorigin="anonymous"></script>
    </body>
</html>
