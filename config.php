<?php
/**
 * Centralized database connection.
 *
 * Previously, every single PHP file in this project opened its own
 * mysqli_connect("localhost","root","") call independently. This file
 * replaces all of those with one shared connection, and allows overriding
 * credentials via environment variables (falls back to the original
 * local defaults if none are set, so existing local setups keep working).
 */

$db_host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') ?: '';
$db_name = getenv('DB_NAME') ?: 'lms';

$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$connection) {
    die('Database connection failed: ' . mysqli_connect_error());
}
