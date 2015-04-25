**This is a page in progress, information here is probably not useful for anyone, except the one making this page**

# VPN Client installation on Linux #

  * Open a terminal window
  * Use the package manager to install openvpn
```
sudo yast2 -i openvpn # for OpenSuse
sudo apt-get install openvpn #for Debian/Ubuntu
yum install openvpn #for Fedora/RedHat/CentOS
```

  * Copy the certificate manager to your home folder (for example)
```
mkdir ~/switchedonvpn
cp -r /usr/share/openvpn/easy-rsa/2.0 ~/switchedonvpn/certificate_manager # for OpenSuse
cp -r /usr/share/doc/openvpn/examples/easy-rsa/2.0 ~/switchedonvpn/certificate_manager # for Debian/Ubuntu
cp -r /usr/share/doc/packages/openvpn/easy-rsa/2.0 ~/switchedonvpn/certificate_manager #for Fedora/RedHat/CentOS
```

  * Go to the switchedonvpn directory and download some configuration files (replace support_with dev_ if wished, if you want to use both, use separate keymanager directories)
```
cd ~/switchedonvpn/
wget -O support_client.conf http://so-class2.googlecode.com/svn/trunk/vpnconfig/vpnclient_linux/support_client.conf
wget -O certificate_manager/keys/ca.crt http://so-class2.googlecode.com/svn/trunk/vpnconfig/vpnclient_linux/ca.crt
wget -O certificate_manager/vars http://so-class2.googlecode.com/svn/trunk/vpnconfig/vpnclient_linux/vars
```

  * Configure config
```
nano support_client.conf # correct the paths for the keys.
```

  * Generate a key request. Give as name the name you got from the SwitchedOn admin
```
cd ~/switchedonvpn/certificate_manager
. ./vars
./build-req [yourname]
```

  * Send the file "keys/`[`yourname`]`.req" to the switchedon admin. DO NOT SHARE THE .key FILE!

  * The admin sends back a `[`yourname`]`.crt file. Place this in the keys folder.
directory. If you putted your certificates in a different folder, change this file accordingly
  * Start the openvpn client
```
sudo openvpn support_client.conf
```

If you want to have the connection always on (or just as a service) you should put the configuration and the certificate\_manager directory in /etc/openvpn.
```
service openvpn start #starts service
chkconfig --add openvpn #service will start on system boot
```


  * Test the connection (for example with ping)
```
ping 10.180.230.1 #for the dev network 10.180.240.1
```