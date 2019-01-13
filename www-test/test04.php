<?php ini_set("display_errors", 1);

require_once (__DIR__."/../vendor/autoload.php");

use Pollus\ImprovedSession\ImprovedSession;

$session = new ImprovedSession();
$session->name("test_session");

echo "Test 04: ";

if ($session->status() === PHP_SESSION_ACTIVE)
{
    die("Failed - Session shound't be active");
}

$session->start();

if ($session->status() === PHP_SESSION_NONE)
{
    die("Failed - Session should be active");
}

echo "Passed!";

header('Location: test05.php');