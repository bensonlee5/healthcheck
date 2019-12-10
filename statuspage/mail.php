<?php
while(1) {
    sleep(60);
    $new_status = [];
    $files = scandir('/var/www/healthcheck.accumedintel.net/statuspage/check_files', SCANDIR_SORT_DESCENDING);
    $newest_file = ($files[0] == 'index.json') ? $files[1] : $files[0];
    $data = json_decode(file_get_contents('/var/www/healthcheck.accumedintel.net/statuspage/check_files/' . $newest_file));
    $status = json_decode(file_get_contents('/var/www/healthcheck.accumedintel.net/statuspage/status.json'));
    foreach ($data as $endpoint) {
        if (!in_array($endpoint->title, $status) && isset($endpoint->down)) {
            //send mail
            shell_exec('echo -c "Subject: Healthcheck Alert!\n\nHealthcheck Alert:\n' .
            $endpoint->title . ' is down." | ssmtp d.foster@accumedintel.com');
        }
        if (isset($endpoint->down)) {
            $new_status[] = $endpoint->title;
        }
    }
    file_put_contents('/var/www/healthcheck.accumedintel.net/statuspage/status.json', json_encode($new_status));
}
?>
