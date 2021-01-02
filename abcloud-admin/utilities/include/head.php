<?php
if (version_compare(phpversion(), '5.5', '<')) {
    // PHP version too low.
    header('Content-type: text/html; charset=utf-8');
    exit('<h2>AB File Manager 3 requires PHP >= 5.5</h2><p>Current: PHP '.phpversion().', please update your server settings.</p>');
}

if (!defined(' AB_APP')) {
    return;
}

if (!file_exists('abcloud-admin/config.php')) {
    if (!copy('abcloud-admin/config-master.php', 'abcloud-admin/config.php')) {
        exit("failed to create the main config.php file, check CHMOD on /abcloud-admin/");
    }
}

if (!file_exists('abcloud-admin/users/users.php')) {
    if (!copy('abcloud-admin/users/users-master.php', 'abcloud-admin/users/users.php')) {
        exit("failed to create the main users.php file, check CHMOD on /abcloud-admin/users/");
    }
}

require_once 'abcloud-admin/config.php';

if ($_CONFIG['debug_mode'] === true) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(E_ALL ^ E_NOTICE);
}

require_once 'abcloud-admin/class.php';

// Redirect blacklisted IPs.
Utils::checkIP();

require_once 'abcloud-admin/users/users.php';
require_once 'abcloud-admin/users/remember.php';
global $translations_index;
$translations_index = json_decode(file_get_contents('abcloud-admin/translations/index.json'), true);

$setUp = new SetUp();

if (SetUp::getConfig("firstrun") === true || strlen($_USERS[0]['pass']) < 1) {
    header('Location:abcloud-admin/login.php');
    exit;
}
require_once 'abcloud-admin/translations/'.$setUp->lang.'.php';

$updater = new Updater();
$gateKeeper = new GateKeeper();
$gateKeeper->init();

$location = new Location();
$downloader = new Downloader();

$updater->init();
$template = new Template();
$imageServer = new ImageServer();

require_once 'abcloud-admin/users/token.php';
$resetter = new Resetter();
$resetter->init();

if ($gateKeeper->isAccessAllowed()) {
    new Actions($location);
};

$getdownloadlist = filter_input(INPUT_GET, "dl", FILTER_SANITIZE_STRING);

require_once 'abcloud-admin/fonts/ AB-icons.php';
