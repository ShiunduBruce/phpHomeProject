This project has been designed from scratch without use of any php framewok although its directory structure resembeles that of LARAVEL framework.

It has been tested to work properly on the XAMPP local development environment and would recommed if on trying out to use the same, to avoid file path issues. The easiest way is to configure your XAMPP which can be done easily by adding the following code of line in your C:\xampp\apache\conf\extra\httpd-vhosts.conf file

# VirtualHost for localhost.myHomeProject.com
 
<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/myHomeProject"
    ServerName localhost.myHomeProject.com  
    <Directory "C:/xampp/htdocs/myHomeProject">
      Options Indexes MultiViews FollowSymLinks
      AllowOverride All
      Require all granted
    </Directory>
</VirtualHost>
and configuring 
C:\Windows\System32\drivers\etc\host
changing the line
127.0.0.1 localhost.myHomeProject.com

Finally, you may need to run the command composer update or composer run in the myHomeProject directory just to update the paths.

