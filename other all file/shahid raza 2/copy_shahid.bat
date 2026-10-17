@echo off
REM ====== Memory card se "shahid" folder safe copy karega ======

:: Source folder ka path (memory card drive letter change karein)
set "SRC=E:\shahid"

:: Destination folder ka path (laptop me jaha save karna hai)
set "DEST=D:\Backup\shahid"

echo Copying files from "%SRC%" to "%DEST%" ...
echo ------------------------------------------------------------

robocopy "%SRC%" "%DEST%" /E /Z /DCOPY:T /R:3 /W:5

echo ------------------------------------------------------------
echo Copy Complete!
pause
