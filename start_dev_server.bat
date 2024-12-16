@echo off
cd /d %~dp0

set PORT=8000
php -S localhost:%PORT% -t public/

pause
