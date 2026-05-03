<?php

declare(strict_types=1);

/**
 * Valida o fluxo MVP automatizado (SQLite em memória via phpunit.xml).
 * Uso: php scripts/verify-mvp-e2e.php
 */

$root = dirname(__DIR__);
chdir($root);

$phpunit = $root . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'phpunit'
    . DIRECTORY_SEPARATOR . 'phpunit' . DIRECTORY_SEPARATOR . 'phpunit';

if (! is_file($phpunit)) {
    fwrite(STDERR, "PHPUnit não encontrado. Correr `composer install` na raiz do app.\n");
    exit(1);
}

$cmd = escapeshellarg(PHP_BINARY) . ' ' . escapeshellarg($phpunit) . ' --filter=MvpEndToEndTest';
passthru($cmd, $code);
exit($code);
