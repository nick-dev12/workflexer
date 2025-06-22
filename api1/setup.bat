@echo off
echo Installation des dependances pour l'API de matching...

REM Verification si Python est installe
python --version > nul 2>&1
if %errorlevel% neq 0 (
    echo Python n'est pas installe ou n'est pas dans le PATH.
    echo Veuillez installer Python 3.8 ou superieur depuis https://www.python.org/downloads/
    pause
    exit /b 1
)

REM Creation d'un environnement virtuel
echo Creation de l'environnement virtuel...
python -m venv venv

REM Activation de l'environnement virtuel
echo Activation de l'environnement virtuel...
call venv\Scripts\activate.bat

REM Installation des dependances
echo Installation des packages requis...
pip install -r requirements.txt

REM Telechargement du modèle français pour spaCy
echo Telechargement du modele francais pour spaCy...
python -m spacy download fr_core_news_sm

echo.
echo Installation terminee avec succes!
echo Pour lancer l'API, executez start_api.bat
echo.

pause 