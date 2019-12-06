<?php
    echo shell_exec('echo -e "Subject: Healthcheck Alert!\n\nHealthcheck Alert:\n' .
        $_GET['endpoint'] . ' is down." | ssmtp sysadmin@accumedintel.com');
?>
