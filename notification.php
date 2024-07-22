<?php
// Notification.php
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

require 'vendor/autoload.php';

function sendNotifications($db, $categorie, $publicKey, $privateKey) {
    // Obtenir les abonnements des utilisateurs de la même catégorie
    $sql = "SELECT * FROM subscriptions JOIN users ON subscriptions.user_id = users.id WHERE users.categorie = :categorie";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(":categorie", $categorie);
    $stmt->execute();
    $subscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $auth = [
        'VAPID' => [
            'subject' => 'mailto:your-email@example.com', // Remplacez par votre email
            'publicKey' => $publicKey,
            'privateKey' => $privateKey,
        ],
    ];

    $webPush = new WebPush($auth);

    foreach ($subscriptions as $sub) {
        $subscription = Subscription::create([
            'endpoint' => $sub['endpoint'],
            'publicKey' => $sub['public_key'],
            'authToken' => $sub['auth_token'],
            'contentEncoding' => $sub['content_encoding'],
        ]);

        $notification = [
            'title' => 'Nouvelle offre d\'emploi',
            'body' => 'Une nouvelle offre d\'emploi a été publiée dans votre catégorie.',
            'icon' => '/path/to/icon.png',
        ];

        $webPush->sendNotification(
            $subscription,
            json_encode($notification)
        );
    }

    foreach ($webPush->flush() as $report) {
        $endpoint = $report->getRequest()->getUri()->__toString();

        if ($report->isSuccess()) {
            echo "[v] Message sent successfully for subscription {$endpoint}.";
        } else {
            echo "[x] Message failed to sent for subscription {$endpoint}: {$report->getReason()}";
        }
    }
}
?>
