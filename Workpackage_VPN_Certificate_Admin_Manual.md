All this actions have to be performed on the vpn server. Copy files from and to the vpn server with scp (Linux) or WinSCP (Windows)

Best to receive the certificates as files created by the OpenVPN client application.  If certificate is received as copy/paste into an email, ensure is created as Unix file (different newline/carriage return to windows) with no extra blank lines inserted, a single new line at the and end the Certificate Starts and Ends labels in place.

# Signing Certificates #

  * Person will send a .csr file. Store this file as `[`username`]`.csr in /etc/openvpn/dev\_keymanager/keys for access to the developer network and /etc/openvpn/support\_keymanager/keys for access to the support network. Below `dev_` is used but this can be change to `support_` if appropriate **Do not forget to run `. ./vars` again when you switch between keymanagers!**

  * Check or certificate already exists (see below). If a certificate with that name already exists, first revoke the old one (see below).

  * Move to key\_manager directory and sign request
```
cd /etc/openvpn/dev_keymanager
. ./vars
./sign-req [username] # No extension
```
This will give an error message on the end (like: chmod: cannot access 'username.key': No such file or directory). This can be ignored.

  * Send back the certificate (`[`username`]`.crt)


# Revoking a certificate #
```
cd /etc/openvpn/dev_keymanager
. ./vars
./revoke-full [username] # No extension
```

# See the database of certificates #
```
less /etc/openvpn/dev_keymanager/keys/index.txt
```
for all certificates
or
```
grep ^V /etc/openvpn/dev_keymanager/keys/index.txt
```
for all valid certificates.

Every line shows a certificate. V means Valid, R means Revoked. CN is the certificate name

# Finding out IP addresses #
People with access to the VPN server can see the following files, but only those currently connected:
  * /etc/openvpn/support\_openvpn-status.log
  * /etc/openvpn/dev\_openvpn-status.log
(Virtual Address under Routing Table)

The IP adresses are persistent for a certificate name, so they are supposed to stay
the same over time.

For all certificates given out, check the certificate admin manual in the bottom. ipp.txt and support\_ipp.txt are also used for storing the persistent addresses.