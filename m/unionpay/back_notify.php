<?php
file_put_contents('/var/www/pinet-fenxiao/cache/unionpay/back_notify', print_r($_POST, 1).PHP_EOL, FILE_APPEND);