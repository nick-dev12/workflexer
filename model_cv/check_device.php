<?php
/**
 * Function to check if the user is accessing from a desktop device
 * Returns true if desktop, false if mobile/tablet
 */
function isDesktop()
{
    $userAgent = $_SERVER['HTTP_USER_AGENT'];

    // Regular expressions for mobile devices
    $mobileRegex = '/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini|Mobile|mobile|CriOS/i';

    // If the user agent matches any mobile pattern, return false (not desktop)
    if (preg_match($mobileRegex, $userAgent)) {
        return false;
    }

    // Otherwise, assume it's a desktop
    return true;
}

// Set session variable to store the device type
function storeDeviceType()
{
    if (!isset($_SESSION)) {
        session_start();
    }

    $_SESSION['is_desktop'] = isDesktop();
    return $_SESSION['is_desktop'];
}
?>