**This is a page in progress, information here is probably not useful for anyone, except the one making this page**

# Installation of the OpenVPN client on Windows #

  * Download the the latest OpenVPN package from [here](http://www.openvpn.net/download.html) (Choose the latest Windows Installer)
  * Install OpenVPN by starting the installer and accepting all default options.
  * If it gives a warning, click "Continue Anyway"

  * Now download the Switched On package [here](http://so-class2.googlecode.com/svn/trunk/vpnconfig/vpnclient_windows/installer/switchedon_vpn_config.exe)
  * Install the package. You can choose the configurations you need (Support network and Developer network).

Vista: Run As Administrator.  Note from Readme: 'on Windows Vista, you will need to run the OpenVPN GUI with administrator privileges, so that it can add routes to the routing table that are pulled from the OpenVPN server. You can do this by right-clicking on the OpenVPN GUI desktop icon, and selecting "Run as administrator".'

  * Start the Certificate Wizard by going to Start-> All Programs -> OpenVPN -> Shortcuts -> configuration file directory. The wizards are in the directory mycert and are called support.bat and dev.bat
  * Fill in your name and email-address and click "Create Request"
![http://so-class2.googlecode.com/svn/wiki/Workpackage_VPN_files/makerequest.png](http://so-class2.googlecode.com/svn/wiki/Workpackage_VPN_files/makerequest.png)

  * Email to the Switched On Admin (admin@switchedon.org) one of the following:
    * The text that is displayed when clicked on "Create Request"
    * The file `[`username`]`.csr in the directory C:\Program Files\OpenVPN\config\switchedon\_network\_keys  (replace network with support or dev)
> > > DO NEVER SEND THE `[`username`]`.key FILE TO ANYONE

  * The admin will send a file back. Save this file in the directory C:\Program Files\OpenVPN\config\switchedon\_network\_keys  (replace network with support or dev)

# Starting the Connection #
  * right-click on the OpenVPN icon in the taskbar
  * choose Connect

> ![http://so-class2.googlecode.com/svn/wiki/Workpackage_VPN_files/startconnection.png](http://so-class2.googlecode.com/svn/wiki/Workpackage_VPN_files/startconnection.png)
  * The connection works if the icon becomes green
> ![http://so-class2.googlecode.com/svn/wiki/Workpackage_VPN_files/connected.png](http://so-class2.googlecode.com/svn/wiki/Workpackage_VPN_files/connected.png)

  * To close the connection, right-click on the icon again and choose disconnect