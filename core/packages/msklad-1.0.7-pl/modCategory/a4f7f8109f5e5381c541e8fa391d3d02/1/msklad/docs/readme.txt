--------------------
mSync (ex mSklad)
--------------------
Author: Rahimov Alexandr <alexzandr@gmail.com>
--------------------
Компонент синхронизации с 1С и сервисами "Класс365", "МойСклад".

url: https://store.simpledream.ru/packages/integration/msklad.html
doc: https://modx.pro/components/4169-msklad-1-0-7-import-characteristics-commerceml-2/


Add support on FastCGI mode:
add code in .htaccess

Add support on FastCGI mode
RewriteCond %{HTTP:Authorization} !^$
RewriteRule ^(.*)$ $1?http_auth=%{HTTP:Authorization} [QSA]
