@echo off
echo [INFO] Création d'un environnement virtuel...

:: Vérifie si Python est installé
where python >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo [ERREUR] Python n'est pas installé ou non accessible dans le PATH.
    pause
    exit /b 1
)

:: Crée un environnement virtuel s'il n'existe pas
if not exist "env" (
    python -m venv env
)

echo [INFO] Activation de l'environnement virtuel...
call env\Scripts\activate.bat

echo [INFO] Mise à jour de pip...
python -m pip install --upgrade pip --no-cache-dir

echo [INFO] Installation des dépendances depuis requirements.txt...
pip install -r requirements.txt --no-cache-dir

echo [INFO] Téléchargement des données NLTK nécessaires...
python -c "import nltk; nltk.download('punkt'); nltk.download('stopwords'); nltk.download('wordnet')"

echo [INFO] Vérification du modèle spaCy français...
python -c "import spacy; spacy.load('fr_core_news_sm')" 2>nul
if %ERRORLEVEL% EQU 0 (
    echo [INFO] Le modèle spaCy 'fr_core_news_sm' est déjà installé.
) else (
    echo [INFO] Téléchargement et installation du modèle spaCy 'fr_core_news_sm'...
    pip install https://github.com/explosion/spacy-models/releases/download/fr_core_news_sm-3.5.0/fr_core_news_sm-3.5.0.tar.gz  --no-cache-dir
)

echo [INFO] Vérification terminée.

echo.
echo ✅ Installation terminée avec succès !
echo Pour lancer l'API, exécutez : start_api.bat
pause