#The technical details for the installed OpenVPN server. Only needed for recovery of server.

**This is a page in progress, information here is probably not useful for anyone, except the one making this page**

# Commands used #
(Login as root first)
```
#install openvpn package
yast -i openvpn

#copy key management directory
cp -r /usr/share/openvpn/easy-rsa /etc/openvpn/

#move to key generation directory
cd /etc/openvpn/easy-rsa/2.0/

#download vars file and openssl.cnf file


#set environment variables (the extra dot is no mistake)
. ./vars

#clean all certificates
./clean-all

#create authority
./build-ca

#create server certificate (just take defaults (press enter) and y)
./build-key-server server

#create dh keys
./build-dh

#create and revoke a certificate (to be able to test revocation and to initialize the revocation db)
./build-key test_revoked_client
./revoke-full test_revoked_client

#go to main openvpn dir
cd /etc/openvpn/

#download server configuration


#let the server start automatically
chkconfig -a openvpn

#start the server
service openvpn start



```