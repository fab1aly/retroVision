<?php

// Fonction pour charger les variables d'environnement depuis un fichier .env
function loadEnv($file)
{
    if (!file_exists($file))
    {
        return;
    }

    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line)
    {
        if (strpos(trim($line), '#') === 0)
        {
            continue;
        }

        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);

        if (!array_key_exists($name, $_ENV))
        {
            putenv("$name=$value");
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}

// Charger le fichier .env
loadEnv(ROOT . '/.env');

return [
    'database' => [
        'dsn' => 'mysql:dbname=' . getenv('DB_NAME') . ';host=' . getenv('DB_HOST') . ';charset=' . getenv('DB_CHARSET'),
        'username' => getenv('DB_USERNAME'),
        'password' => getenv('DB_PASSWORD'),
        'options' => [
            PDO::ATTR_DEFAULT_FETCH_MODE => getenv('PDO_FETCH_MODE') === 'assoc' ? PDO::FETCH_ASSOC : PDO::FETCH_BOTH,
            PDO::ATTR_ERRMODE => getenv('PDO_ERRMODE') === 'exception' ? PDO::ERRMODE_EXCEPTION : PDO::ERRMODE_SILENT
        ]
    ]
];
