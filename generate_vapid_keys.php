<?php
require 'vendor/autoload.php';

use Minishlink\WebPush\VAPID;

$vapidKeys = VAPID::createVapidKeys();

echo "Public Key: " . $vapidKeys['publicKey'] . PHP_EOL;
echo "Private Key: " . $vapidKeys['privateKey'] . PHP_EOL;
