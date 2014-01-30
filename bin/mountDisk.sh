#!/bin/bash

content=`ls /mnt/drive`

if [ "$content" == "" ];
then
  echo "Pripojovani sifrovaneho disku, nejdrive heslo pro spravce (sudo), potom heslo pro sifrovany disk"
  sudo cryptsetup luksOpen /dev/sdb1 secretvol
  sudo mount /dev/mapper/secretvol /mnt/drive
  echo "OK /mnt/drive je pripraveny"
else
  echo "/mnt/drive je jiz pripojen"
fi

