@echo off
title Nazelle Delices - Artisan Bakery & Pastry Server
echo ========================================================================
echo       NAZELLE DELICES - PATISSERIE & BOULANGERIE ARTISANALE
echo ========================================================================
echo.

:: 1. Deteksi executable PHP
set "PHP_BIN=php"
where php >nul 2>&1
if %errorlevel% neq 0 (
    if exist "C:\xampp82\php\php.exe" (
        set "PHP_BIN=C:\xampp82\php\php.exe"
    ) else if exist "C:\xampp\php\php.exe" (
        set "PHP_BIN=C:\xampp\php\php.exe"
    )
)

echo [INFO] Menggunakan PHP: %PHP_BIN%

:: 2. Cek file .env
if not exist ".env" (
    echo [INFO] File .env belum ada. Menyalin dari .env.example...
    copy ".env.example" ".env" >nul
    "%PHP_BIN%" artisan key:generate --force
)

:: 3. Cek file database SQLite (jika menggunakan SQLite default)
findstr /i "^DB_CONNECTION=sqlite" .env >nul 2>&1
if %errorlevel% equ 0 (
    if not exist "database\database.sqlite" (
        echo [INFO] Menyiapkan database SQLite baru...
        type nul > "database\database.sqlite"
        "%PHP_BIN%" artisan migrate --seed --force
    )
)

echo.
echo ========================================================================
echo Website Nazelle Delices siap diakses di browser:
echo -> http://127.0.0.1:8000
echo.
echo Akun Demo Bawaan:
echo - Admin / Owner : admin@nazelle.test (password: password)
echo - Staff Kasir   : staff@nazelle.test (password: password)
echo - Pelanggan     : pelanggan@nazelle.test (password: password)
echo.
echo Tekan CTRL + C untuk menghentikan server.
echo ========================================================================
echo.

"%PHP_BIN%" artisan serve --host=127.0.0.1 --port=8000
pause
