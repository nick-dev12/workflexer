<?php
/**
 * Function to check if the user is accessing from a desktop device
 * Returns true if desktop, false if mobile/tablet
 */
function isDesktop()
{
    $userAgent = $_SERVER['HTTP_USER_AGENT'];

    // Liste des expressions régulières pour détecter les appareils mobiles
    $mobileRegex = '/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i';

    // Vérifier si c'est un appareil mobile
    if (preg_match($mobileRegex, $userAgent)) {
        return false;
    }

    // Vérifier la taille de l'écran via les en-têtes HTTP
    if (isset($_SERVER['HTTP_X_WAP_PROFILE']) || 
        isset($_SERVER['HTTP_PROFILE']) || 
        isset($_SERVER['HTTP_ACCEPT']) && 
        (strpos($_SERVER['HTTP_ACCEPT'], 'text/vnd.wap.wml') !== false || 
         strpos($_SERVER['HTTP_ACCEPT'], 'application/vnd.wap.xhtml+xml') !== false)) {
        return false;
    }

    return true;
}

// Vérifier immédiatement si l'utilisateur est sur mobile
if (!isDesktop()) {
    header("Location: mobile_message.php");
    exit;
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