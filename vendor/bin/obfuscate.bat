@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../naneau/php-obfuscator/bin/obfuscate
php "%BIN_TARGET%" %*
