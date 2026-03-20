# สร้าง Container สำหรับ WebApp
FROM php:7.4-apache

# ติดตั้ง MySQL extension
RUN docker-php-ext-install mysqli

# กำหนด Directory สำหรับเก็บไฟล์เว็บ
COPY . /var/www/html/

EXPOSE 80