Go back to [Workpackages](Workpackages.md).

<h1>Table of Contents</h1>


# Introduction #
The configuration of Switched On has several parts:
  1. A **tool creation script** to get all resouces from HQ and create an Installation CD containing all needed pckages, configuration file and artefacts.
> This will either be run from HQ and the CDs shipped to the centres, or it can be run from the centres and will get the information from HQ over the internet (for when link speeds get fast enough).

  1. An **install script** which will turn an openSUSE 11.1 machine into a _Switched On_ machine, installing all needed packages, configuration files and artefacts.
> This runs at the centres from the CD created in step 1.  It should be fully automaic (or as near to as possible).

  1. The **Switched On Configuration Tool** - which runs automatically in a browser from the Installation CD once the machine has been _Switched On_.  This allows installing of Lessons, Media and (perhaps) users contained on the CD.
> The same CD as step 2, but once it has detected that the machine has been switched on, then this is run.

## Tentative mapping of install/config stages to physical media ##

### Install ###
| Media / Stage | Individual steps |
|:--------------|:-----------------|
| Backup data if is existing system | User accounts, Moodle non-course info (i.e. courses and media will be installed later) |
| SUSE: installation standard distro | e.g. OpenSUSE 11.1, 2, ... |
| SO install CD (operation) | Add RPMs for SO-needed apps.  e.g. Apache, MySQL, ... |
| SO install CD | SO-specific, global config of system |
| SO install CD | SO-specific, centre-specific config of system |
| SO install CD | Moodle install shar file. Note 1. Not SUSE package because want to fix the version.  This enables direct config of the database, the structure of which may change even across minor package revisions, to facilitate auto-config. Note 2. Shar file executes script to configure Moodle (incl MySQL) |
| SO install CD | Restore backed-up data (unless is first install) - user accounts, ... (see above backup step) |
| SO install CD | Course materials, incl Moodle courses and Media (encrypted if can) |

Options:
Autoyast
Kiwi

### Update process ###
| Types of updates | Individual steps |
|:-----------------|:-----------------|
| Distro updates | Update RPMs. Options: download over net, SUSE Patch CD|
| Moodle updates | Options: download over net (Moodle's own upgrade mechanism), our own Patch process if net connection not good enough |
| Existing course material revisions |  |
| News moodle courses |  |
| New applications | Distro RPM install |
| New applications | Config - global and/or centre-specific |
| SO config changes | SO-specific, global config of system |
| SO config changes | SO-specific, centre-specific config of system  |

Issues:
  * When restoring moodle data (e.g. User results), will it be associated with the right artefacts.  e.g. will a score be associated with the correct quiz?

users
Linux:
Minor revisions and major revisions
Moodle upgrades - via Linux distro or downloaded directly and upgraded by Moodle itself, overwriting PHP files, moding database etc.


# Requirements #

  * Base configuration should be the same for all main servers (thin client server)
  * Must be some configurations specific to each centre, that will be applied the same each time the system is installed (i.e. at a particular centre):
    * Server name
    * Network address ranged used in the classroom
    * VPN setup - certificate installed etc

# Tasks #

|**Description**                                     |**Developer**|**Started**|**Complete**|
|:---------------------------------------------------|:------------|:----------|:-----------|
|_Switched On Splash Screen_                       | .      | .        | .        |
| Put the switched on logo on the openSUSE splah   | NR&AB  | 3/10/09  | 3/10/09  |
|.                                                 | .      | .        | .        |
|_Tool Creation Script_                            | .      | .        | .        |
| Script that will create an installation directory | .     | .        | .        |
| Script that creates CD from a specified directory | .     | .        | .        |
|.                                                 | .      | .        | .        |
|_Installation Script_                             | .      | .        | .        |
| Installs packages (moodle, apache, etc.)         | .      | .        | .        |
| Install extra Switched On files                  | .      | .        | .        |
| Install configuration files                      | .      | .        | .        |
| Requests centre ID and gets settings from file   | .      | .        | .        |
|.                                                 | .      | .        | .        |
|_Switced On Configuration Tool_                   | .      | .        | .        |
| Javascript or php which will detect the state of the machine | .      | .        | .         |
| Upgrade Lessons                                  | .      | .        | .        |
| Upgrade Media                                    | .      | .        | .        |
| Upgrade Users                                    | .      | .        | .        |
| Upgrade Switched On                              | .      | .        | .        |
| Upgrade/Reset Site Confguration                  | .      | .        | .        |
|.                                                 | .      | .        | .        |
|_Documentation_                                   | .      | .        | .        |
| Update Wiki documentation for this workpackage.  | AB     | 23/09/09 | .        |


# Team documentation #
(Description of your product, dependencies, how to install, use, modify, outstanding issues etc.)
To Be Written - AB

## Methods ##
Here are some notes on the methods used to do some things:
### To change the splash screen ###
  1. Find the resolution
The resolution we are using for our splash screen is 800x600.
This was found out by running:  `sudo /sbin/mkinitrd`
It is on the second last line after "Bootsplash"

> 2. Get the splash screen
The splash screen we use was located in `/etc/bootsplash/themes/openSUSE/images/silent-800x600.jpg`
This was uploaded to the repository in [revision 353](https://code.google.com/p/so-class2/source/detail?r=353) (you can get the original there).

> 3. Edit the splash screen
This was edited with Photoshop CS3 and saved NOT progressive.
The colour mode changes when you do this so we had to load it in the GIMP and re-save it with Not Progressive, Mode = YCbCr and 2x2,1x1,1x1 as the Subsampling.

> 4. Copy this file back over the original in `/etc/bootsplash/themes/openSUSE/images/silent-800x600.jpg`

> 5. Update the ramdisk image used to boot Linux
Run `sudo /sbin/mkinitrd` again.  This time it will be using the new splash!
The first time we did this it complained about the picture not being a 221111 jpeg.  The steps above fixed that.

> 6. Reboot to test and enjoy.

#### To include in the install ####

  1. Copy the new image to `/etc/bootsplash/themes/openSUSE/images/silent-800x600.jpg`
  1. run  `sudo /sbin/mkinitrd`  **<-- Note: This needs to be run as root**

### To get a CD to Auto boot in openSUSE ###

  * There needs to be a script or binary on the CD called **autorun** which needs to be executable.
  * There needs to be a line similar to this in '/etc/fstab':
```
   /dev/sr1    /media/cdrom1   iso9660    user,noauto,exec,utf8  0 0
```

This will auto start the autorun file, but the user will still need to confirm that they want the programme to run.

Unfortunately this will mean that the first install will not be automatic (ie, the installation of the switched on files), but after that, the configuration CD will (or can be made to) work automatically.



---


# Workpackage Team Members #
  * Adam Bewsher
  * Neil Rogers
  * Ken Goddard (at first dev. weekend)