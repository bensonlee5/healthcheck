<?php
$new_status = [];
$files = scandir('/var/www/healthcheck.accumedintel.net/statuspage/check_files', SCANDIR_SORT_DESCENDING);
$newest_file = $files[0];
$data = json_decode(file_get_contents('/var/www/healthcheck.accumedintel.net/statuspage/check_files/' . $newest_file));
$status = json_decode(file_get_contents('/var/www/healthcheck.accumedintel.net/statuspage/status.json'));
foreach ($data as $endpoint) {
    if (!in_array($endpoint->title, $status) && $endpoint->down) {
        //send mail
        $new_status[] = $endpoint->title;
    }
}
file_put_contents('/var/www/healthcheck.accumedintel.net/statuspage/status.json', json_encode($new_status));
?>
