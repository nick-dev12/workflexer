# Configuration de la tâche Cron pour l'envoi d'emails sur Namecheap

Ce guide explique comment configurer la tâche Cron pour l'envoi automatique d'emails sur un hébergement Namecheap.

## Prérequis

- Un hébergement Namecheap avec accès cPanel
- PHP 7.4 ou supérieur installé
- Les extensions PHP nécessaires (curl, json, mysqli)

## Configuration de la tâche Cron

1. Connectez-vous à votre compte Namecheap
2. Accédez à votre cPanel
3. Dans la section "Avancé", cliquez sur "Cron Jobs"
4. Cliquez sur "Ajouter une nouvelle tâche Cron"

### Paramètres de la tâche

- **Fréquence** : Toutes les 5 minutes
- **Commande** : 
```bash
php /chemin/vers/votre/site/entreprise/app/cron/send_emails.php
```

### Exemple de configuration

```
*/5 * * * * php /home/username/public_html/entreprise/app/cron/send_emails.php
```

## Vérification de la configuration

1. Dans cPanel, allez dans "Cron Jobs"
2. Vérifiez que la tâche apparaît dans la liste
3. Cliquez sur "Voir la sortie" pour vérifier les logs d'exécution

## Dépannage

Si la tâche ne s'exécute pas correctement :

1. Vérifiez les permissions des fichiers :
   ```bash
   chmod 755 /chemin/vers/votre/site/entreprise/app/cron/send_emails.php
   chmod 755 /chemin/vers/votre/site/entreprise/app/cron
   ```

2. Vérifiez les logs d'erreur dans cPanel :
   - Allez dans "Error Log"
   - Recherchez les erreurs liées à l'exécution du script

3. Testez manuellement le script :
   ```bash
   php /chemin/vers/votre/site/entreprise/app/cron/send_emails.php
   ```

## Notes importantes

- Assurez-vous que le chemin vers PHP est correct dans votre configuration
- Vérifiez que les permissions des fichiers sont correctes
- Les emails en attente sont stockés dans la base de données
- Le script traite un maximum de 50 emails par exécution
- Une pause de 500ms est ajoutée entre chaque envoi pour éviter la surcharge

## Support

En cas de problème, contactez le support Namecheap ou consultez la documentation de votre hébergement. 