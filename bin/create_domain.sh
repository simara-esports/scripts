#!/bin/bash

name=$1

echo $name  

dir=/mnt/drive/www/$name

if [ -d $dir ]; then
  echo "Slozka $dir jiz existuje"
  exit
fi

echo "-- vytvarim slozku $dir --"
mkdir $dir
mkdir $dir/www

link=/var/www/$name
echo "-- vytvarim symlink $link --"
ln -s $dir $link

echo "-- vytvarim zaznam v /etc/hosts --"
echo "127.0.0.1       $name" | sudo tee -a /etc/hosts

apacheSite=/etc/apache2/sites-available/$name.conf
echo "-- vytvarim zaznam v $apacheSite --"
sudo touch $apacheSite
sudo echo "<VirtualHost *:80>
        ServerName $name
        DocumentRoot /var/www/$name/www
</VirtualHost>" | sudo tee -a $apacheSite

echo "-- Apache povoluje virtualhost $name"
sudo a2ensite $name.conf

echo "-- Restartuju Apache"
sudo service apache2 restart 

exit