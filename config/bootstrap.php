<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

if (!array_key_exists('APP_ENV', $_SERVER)) {
    $_SERVER['APP_ENV'] = $_ENV['APP_ENV'] ?? null;
}

if (isset($_SERVER['PHP_SELF']) && strpos($_SERVER['PHP_SELF'], 'phpunit') !== false) {
    $_SERVER['APP_ENV'] = $_ENV['APP_ENV'] = 'test';
}

if ('prod' !== $_SERVER['APP_ENV']) {
    if (!class_exists(Dotenv::class)) {
        throw new RuntimeException('The "APP_ENV" environment variable is not set to "prod". Please run "composer require symfony/dotenv" to load the ".env" files configuring the application.');
    }

    (new Dotenv(false))->loadEnv(dirname(__DIR__).'/.env');
}

$_SERVER['APP_ENV'] = $_ENV['APP_ENV'] = $_SERVER['APP_ENV'] ?: $_ENV['APP_ENV'] ?: 'dev';
$_SERVER['APP_DEBUG'] = $_SERVER['APP_DEBUG'] ?? $_ENV['APP_DEBUG'] ?? 'prod' !== $_SERVER['APP_ENV'];
$_SERVER['APP_DEBUG'] = $_ENV['APP_DEBUG'] = (int) $_SERVER['APP_DEBUG'] || filter_var($_SERVER['APP_DEBUG'], FILTER_VALIDATE_BOOLEAN) ? '1' : '0';

if ('test' === $_SERVER['APP_ENV']) {
    $basename = $_ENV['TEST_DATABASE_DUMP_BASENAME'] ?? null;
    if ($basename) {
        $sourceFile = dirname(__DIR__) . '/tests/fixtures/initdb.d/' . $basename;
        if (file_exists($sourceFile)) {
            $tmpFile = sys_get_temp_dir() . '/' . $basename;
            $content = file_get_contents($sourceFile);

            $search1 = "-- CREATE DATABASE archiraq WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'en_US.UTF-8';";
            $replace1 = "CREATE DATABASE archiraq_test WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'en_US.UTF-8';";
            $content = str_replace($search1, $replace1, $content);

            $search2 = "\\connect archiraq";
            $replace2 = "\\connect archiraq_test";
            $content = str_replace($search2, $replace2, $content);

            file_put_contents($tmpFile, $content);

            $pgPassword = $_ENV['POSTGRES_PASSWORD'] ?? 'password';
            $pgUser = $_ENV['POSTGRES_USER'] ?? 'archiraq_admin';
            $pgPort = $_ENV['POSTGRES_PORT'] ?? '5432';
            $pgHost = $_ENV['POSTGRES_HOST'] ?? 'database';

            $envPrefix = sprintf('PGPASSWORD=%s ', escapeshellarg($pgPassword));
            $psqlArgs = sprintf('-U %s -h %s -p %s', escapeshellarg($pgUser), escapeshellarg($pgHost), escapeshellarg($pgPort));

            // First drop the database if it exists.
            shell_exec($envPrefix . 'psql ' . $psqlArgs . ' -d postgres -c "DROP DATABASE IF EXISTS archiraq_test (FORCE);" > /dev/null 2>&1');
            shell_exec($envPrefix . 'psql ' . $psqlArgs . ' -d postgres -f ' . escapeshellarg($tmpFile) . ' > /dev/null 2>&1');
            echo "Database initialized from $sourceFile\n";
        }
    }
}
