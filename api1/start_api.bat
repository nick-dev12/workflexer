@echo off
echo Demarrage de l'API de matching...

REM Activation de l'environnement virtuel
call venv\Scripts\activate.bat

REM Lancement de l'API
echo L'API sera accessible a l'adresse http://localhost:8000
echo Pour arreter l'API, appuyez sur CTRL+C
echo.
uvicorn main:app --reload --host 0.0.0.0 --port 8000

pause 