**This is a page in progress, information here is probably not useful for anyone, except the one making this page**

# VPN Client installation in Classroom #

Currently this is not really automated. This could be putted in a bash file and use a variable for the centername.

The only problem is the key exchange. How are we gonna do that?

```
sudo yast2 -i openvpn
cp -r /usr/share/openvpn/easy-rsa/2.0 /etc/openvpn/certificate_manager
mkdir /etc/openvpn/certificate_manager/keys
wget -O /etc/openvpn/client.conf http://so-class2.googlecode.com/svn/trunk/vpnconfig/vpnclient_linux/client.conf
wget -O /etc/openvpn/certificate_manager/keys/ca.crt http://so-class2.googlecode.com/svn/trunk/vpnconfig/vpnclient_linux/ca.crt
wget -O /etc/openvpn/certificate_manager/vars http://so-class2.googlecode.com/svn/trunk/vpnconfig/vpnclient_linux/vars

sed -i s/NAMECENTER/[therealcentername]/g /etc/openvpn/client.conf # replace [therealcentername] !. e.g s/NAMECENTER/london/g

cd /etc/openvpn/certificate_manager
. ./vars
./build-req [therealcentername] # this script is currently interactive. TODO: make not interactive

```

The part below should be maybe automated somehow.


  * Send the file "keys/`[`therealcentername`]`.req" to the switchedon admin. DO NOT SHARE THE .key FILE!

  * The admin sends back a `[`therealcentername`]`.crt file. Place this in the /etc/openvpn/certificate\_manager/keys folder.
directory.

  * Add the openvpn service and start
```
chkconfig --add openvpn
service openvpn start
```

  * Test the connection (for example with ping)
```
ping 10.20.0.1
```