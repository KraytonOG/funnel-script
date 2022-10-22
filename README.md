# Basic Funnel Script v1
There will be a few things that you need to install server-side..

Ubuntu/Debian
1. Install PHP (`apt install php`)
2. Install PHP-cURL (`apt install php-curl`)
3. Restart Web Server (`systemctl restart apache2/nginx`)

Centos
1. Install PHP (`yum install php`)
2. Install PHP-cURL (`yum install php-curl`)
3. Restart Web Server (`systemctl restart httpd`)

Now that you have PHP installed, throw api.php into /var/www/html...
Then edit everything to your liking and restart the web server again.

The API link will then be:
```sh
http://website.com/api.php?host=[host]&port=[port]&time=[time]&method=[method]
   ```
