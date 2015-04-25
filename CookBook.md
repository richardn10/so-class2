Go back to [Home](Home.md).

# This page is Work in Progress and may change significantly #

# Development server requirements #
  * Server with at least 6GB HD & 512 MB RAM. [VMWare Server](http://www.vmware.com/products/server/) recommended
  * Fast internet connection from the server (for downloads).  Most efficient if has DHCP server to auto-assign IP connection details
  * OpenSUSE 11.1 DVD - from http://software.opensuse.org/

# Installing the server software #
  1. InitialOpenSuseSetup - partition and standard install with Gnome desktop:
    * Use standard OpenSUSE 11.1 DVD (above)
    * AutoInstall
  1. ModifyInstalledPackages
    * via broadband network connection
    * via AdditionalInstallDvd (where network poor)
  1. Apply ConfigChanges and install Switched On special files

# Installing the thin client software #
This is only necessary if your Client PC network card/BIOS are not PXE boot-capable.
  * InstallThinClientSoftware

# Creating Installation Artefacts #
These are the files necessary to complete the above steps to install the server and client.  These procedures are only necessary if you are a developer/tester and need to perform an installation incorporating system changes.
  1. CreatePackageModificationScript
  1. CreateAdditionalInstallDvd
  1. CreateConfigChangesArchive
  1. CreateAutoInstallDvd
  1. CreateClientInstallMedia

# Checking software in/out #
The following are stored in the Google Code repository:
  1. ConfigFiles - includes system/application config and any Switched On files not included in packages (i.e. packages installed in phases 1 and 2 of "Installing the server software")
  1. DevelopmentTools - for managing the development, installation and upgrade processes.