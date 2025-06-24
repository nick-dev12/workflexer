@echo off
echo Installation du package WorkFlexer Matching API en mode développement...

:: Activer l'environnement virtuel s'il existe
if exist "env\Scripts\activate.bat" (
    call env\Scripts\activate.bat
) else (
    echo Création de l'environnement virtuel...
    python -m venv env
    call env\Scripts\activate.bat
    pip install -r requirements.txt
)

:: Installer le package en mode développement
pip install -e .

echo Installation terminée.
pause 