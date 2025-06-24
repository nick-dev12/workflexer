@echo off
echo ===================================
echo WorkFlexer Matching API - Démarrage
echo ===================================

REM Activation de l'environnement virtuel
call env\Scripts\activate

REM Vérification de l'activation
if errorlevel 1 (
    echo Erreur lors de l'activation de l'environnement virtuel.
    echo Veuillez exécuter la commande suivante manuellement :
    echo python -m venv env
    echo env\Scripts\activate
    echo pip install -r requirements.txt
    exit /b 1
)

echo Environnement virtuel activé avec succès.

REM Démarrage de l'API
echo Démarrage de l'API...
python main.py

REM En cas d'erreur
if errorlevel 1 (
    echo Erreur lors du démarrage de l'API.
    echo Veuillez vérifier les logs pour plus d'informations.
    pause
    exit /b 1
)

pause 