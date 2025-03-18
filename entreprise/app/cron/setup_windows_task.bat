@echo off
echo Configuration d'une tache planifiee pour l'envoi d'emails en arriere-plan
echo =======================================================================

REM Obtenir le chemin absolu du script PHP
set "script_path=%~dp0send_emails.php"

REM Obtenir le chemin de PHP
for /f "tokens=*" %%i in ('where php') do set "php_path=%%i"

REM Créer le fichier XML pour la tâche planifiée
echo ^<?xml version="1.0" encoding="UTF-16"?^> > email_task.xml
echo ^<Task version="1.2" xmlns="http://schemas.microsoft.com/windows/2004/02/mit/task"^> >> email_task.xml
echo   ^<RegistrationInfo^> >> email_task.xml
echo     ^<Description^>Envoie les emails en attente dans la file d'attente^</Description^> >> email_task.xml
echo   ^</RegistrationInfo^> >> email_task.xml
echo   ^<Triggers^> >> email_task.xml
echo     ^<TimeTrigger^> >> email_task.xml
echo       ^<Repetition^> >> email_task.xml
echo         ^<Interval^>PT5M^</Interval^> >> email_task.xml
echo         ^<StopAtDurationEnd^>false^</StopAtDurationEnd^> >> email_task.xml
echo       ^</Repetition^> >> email_task.xml
echo       ^<StartBoundary^>2023-01-01T00:00:00^</StartBoundary^> >> email_task.xml
echo       ^<Enabled^>true^</Enabled^> >> email_task.xml
echo     ^</TimeTrigger^> >> email_task.xml
echo   ^</Triggers^> >> email_task.xml
echo   ^<Principals^> >> email_task.xml
echo     ^<Principal id="Author"^> >> email_task.xml
echo       ^<LogonType^>InteractiveToken^</LogonType^> >> email_task.xml
echo       ^<RunLevel^>LeastPrivilege^</RunLevel^> >> email_task.xml
echo     ^</Principal^> >> email_task.xml
echo   ^</Principals^> >> email_task.xml
echo   ^<Settings^> >> email_task.xml
echo     ^<MultipleInstancesPolicy^>IgnoreNew^</MultipleInstancesPolicy^> >> email_task.xml
echo     ^<DisallowStartIfOnBatteries^>false^</DisallowStartIfOnBatteries^> >> email_task.xml
echo     ^<StopIfGoingOnBatteries^>false^</StopIfGoingOnBatteries^> >> email_task.xml
echo     ^<AllowHardTerminate^>true^</AllowHardTerminate^> >> email_task.xml
echo     ^<StartWhenAvailable^>true^</StartWhenAvailable^> >> email_task.xml
echo     ^<RunOnlyIfNetworkAvailable^>false^</RunOnlyIfNetworkAvailable^> >> email_task.xml
echo     ^<IdleSettings^> >> email_task.xml
echo       ^<StopOnIdleEnd^>true^</StopOnIdleEnd^> >> email_task.xml
echo       ^<RestartOnIdle^>false^</RestartOnIdle^> >> email_task.xml
echo     ^</IdleSettings^> >> email_task.xml
echo     ^<AllowStartOnDemand^>true^</AllowStartOnDemand^> >> email_task.xml
echo     ^<Enabled^>true^</Enabled^> >> email_task.xml
echo     ^<Hidden^>false^</Hidden^> >> email_task.xml
echo     ^<RunOnlyIfIdle^>false^</RunOnlyIfIdle^> >> email_task.xml
echo     ^<WakeToRun^>false^</WakeToRun^> >> email_task.xml
echo     ^<ExecutionTimeLimit^>PT10M^</ExecutionTimeLimit^> >> email_task.xml
echo     ^<Priority^>7^</Priority^> >> email_task.xml
echo   ^</Settings^> >> email_task.xml
echo   ^<Actions Context="Author"^> >> email_task.xml
echo     ^<Exec^> >> email_task.xml
echo       ^<Command^>%php_path%^</Command^> >> email_task.xml
echo       ^<Arguments^>"%script_path%"^</Arguments^> >> email_task.xml
echo       ^<WorkingDirectory^>%~dp0^</WorkingDirectory^> >> email_task.xml
echo     ^</Exec^> >> email_task.xml
echo   ^</Actions^> >> email_task.xml
echo ^</Task^> >> email_task.xml

echo Tache planifiee creee dans le fichier email_task.xml

echo.
echo Pour installer la tache, executez la commande suivante en tant qu'administrateur :
echo schtasks /create /tn "WorkFlexer_EmailQueue" /xml "%~dp0email_task.xml" /f
echo.
echo Ou bien, ouvrez le Planificateur de taches de Windows et importez le fichier email_task.xml

pause 