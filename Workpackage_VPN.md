Go back to [Workpackages](Workpackages.md).

# Introduction #
Read WorkpackageDocumentationInstructions

# Created Pages #
  * [Workpackage\_VPN\_ServerConfiguration](Workpackage_VPN_ServerConfiguration.md)
  * [Workpackage\_VPN\_Client](Workpackage_VPN_Client.md)
  * [Workpackage\_VPN\_Client\_Windows](Workpackage_VPN_Client_Windows.md)
  * [Workpackage\_VPN\_Client\_Linux](Workpackage_VPN_Client_Linux.md)
  * [Workpackage\_VPN\_Client\_Classroom](Workpackage_VPN_Client_Classroom.md)
  * [Workpackage\_VPN\_Certificate\_Admin\_Manual](Workpackage_VPN_Certificate_Admin_Manual.md)
  * [Workpackage\_VPN\_Create\_Installer\_Windows](Workpackage_VPN_Create_Installer_Windows.md)

# Requirements #

## Specific questions/strategies to be addressed if time ##
Summary: Configuration of the Switched On central server and clients to enable virtual private networking for use by the distribited development team and easy access to learning centre networks for administration and support.

The following two VPNs are required:
  * A developer VPN e.g. for use during the developer weekends to enable access to each other's PCs on collaborative workpackages.  Developers will be running Windows XP, Vista and maybe flavours of Linux
  * A support VPN to be used to provide admin support to the learning centres.  Currently the Ychtus centre's main server is on SUSE Linux 10.3 64bit.  The Burmese community laptop will run Wondows Vista Home Basic.  The only alternative is to open ports in firewalls, do port forwarding and set up dynamic DNS but experience has shown this to be very tedious task when trying to do it remotely because of trying to guide the local admin person (often v inexperienced) through router setup pages.  Better to point them to a web site to download an openVPN client and give them a simple set of instructions to configure it.
  * certificates will be generated and signed on the vpnserver
  * separate VPNs for developers from centre support.  Good security follows the "need to know/access" principle and most SO developers don't need access to user info stored in the learning centres.  1195 should be used by the developers.  The default 1194 used in the learning centres as sometimes we may need to guide the local admins in the learning centres to set up PCs (e.g. if building from scratch if a hard disk failure) so best if they can use defaults where possible.
  * clustering, not needed
  * config files stored in google code repository
  * All passwords/security certificates must be transferred privately (not on this wiki).

An OpenVPN server Virtual machine will be set up on a central Switched On server which you will be given access to.  This should be made to run with minimum memory necessary in normal use.

This page and subpages should detail the steps for configuration of both the server and clients and link to config files (minus passwords/secure keys!) in the source code repository.

It may be helpful to automate certain operations through scripts, or it may be best to just detail the steps in the wiki.

Happy coding and configuring!

# Team documentation #

# Status #
In progress


---


# Workpackage Team Members #
  * Peter Smit
  * Richard Newbould