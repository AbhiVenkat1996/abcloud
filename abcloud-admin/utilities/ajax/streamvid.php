<?php
require_once '../config.php';
require_once '../class/class.setup.php';
require_once '../class/class.gatekeeper.php';
$setUp = new SetUp();

if (!GateKeeper::isAccessAllowed() && $setUp->getConfig('share_playvideo') !== true) {
    die('access denied');
}
$get = filter_input(INPUT_GET, 'vid', FILTER_SANITIZE_STRING);
$path = '../../'.urldecode(base64_decode($get));
require_once '../class/class.videostream.php';
$stream = new VideoStream($path);

if ($get && $stream->checkVideo() == true) {
    $stream->_start();
}
exit;