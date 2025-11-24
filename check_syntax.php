<?php
$files = [
    'app/models/User.php',
    'app/controllers/UserController.php',
    'app/config/routes.php'
];

foreach ($files as $file) {
    $output = [];
    $return_var = 0;
    exec("php -l " . escapeshellarg($file), $output, $return_var);
    if ($return_var === 0) {
        echo "Syntax OK: $file\n";
    } else {
        echo "Syntax Error: $file\n";
        print_r($output);
    }
}
