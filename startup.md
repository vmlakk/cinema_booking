## Инструкция по запуску проекта на Windows

1. [Установите xampp](https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/8.2.12/xampp-windows-x64-8.2.12-0-VS16-installer.exe)
2. [Установите php 8.3](https://windows.php.net/downloads/releases/php-8.3.1-nts-Win32-vs16-x64.zip), распакуйте в **C:/php8**
3. Зайдите в "Переменные и среды" и добавьте в переменные пользователя (Path) новое значение `C:/php8`
4. [Установите composer](https://getcomposer.org/Composer-Setup.exe)
5. В файле C:/php8/php.ini раскомментируйте строчки (уберите `;`)
    > `;extension=fileinfo` 

    > `;extension=mysqli`

    > `;extension=pdo_mysql`
6. Склонируйте проект `git clone https://github.com/vmlakk/cinema_booking.git` в папку **htdocs**
7. Запустите терминал в папке со склонированным проектом. Напишите там `composer install` для установки всех нужных библиотек.
8. Удалить расширение .DELETEME файла .env.DELETEME (должно получиться .env)
9. Запустите xampp (Apache и Mysql), в папке склонированного проекта в терминале введите команду `php artisan migrate`, а также `php artisan storage:link`
10. Перейдите по [ссылке](http://localhost/cinema_booking/public/index.php) в браузере.
11. Для последующего запуска проекта, достаточно включить xampp и перейти по ссылке из пункта 10.