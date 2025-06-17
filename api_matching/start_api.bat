@echo off
echo Démarrage de l'API de matching pour WorkFlexer...
echo ===============================================

REM Activation de l'environnement virtuel
call env\Scripts\activate.bat

REM Démarrage de l'API avec uvicorn
echo L'API démarre sur http://localhost:8000
echo Pour arrêter l'API, appuyez sur Ctrl+C
echo.
python -m uvicorn main:app --reload --host 0.0.0.0 --port 8000

pause 