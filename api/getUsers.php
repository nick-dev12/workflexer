<?php
include("../controller/controller_users.php");

$totalUsers = getTotalUsers($db);

echo json_encode($totalUsers);
