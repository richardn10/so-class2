#How to do autoyast to setup partitions and do standard Suse install

# Overview #
This is one way to complete phase 1 of the Switched On server installation.

# Requirements #
  * OpenSUSE 11.1 DVD
  * Pre-prepared Autoyast file.  Currently not described here.

# Autoyast with standard SUSE DVD #
  1. Boot from OpenSUSE 11.1 DVD
  1. Press "Esc" at boot menu within 2 seconds
  1. Enter following kernel parameter very CAREFULLY: **install=cdrom:// autoyast=**_one of the following:_
    * **http://so-class2.googlecode.com/files/autoyast-file.xml** _sub in correct name for autoyast-file.xml_
    * **floppy:///_autoyast-file_.xml**  _sub in correct autoyast filename in root of floppy_
    * **device://_usb-device_/_autoyast-file_.xml**  _e.g. usb-device=sdb1_
> > E.g. **install=cdrom:// autoyast=http://so-class2.googlecode.com/files/ay-ren-081229-1.xml** <br>
<blockquote><i>Warning: If you enter this parameter incorrectly</i> you will have to begin the installation from scratch and will not find out until some way into the process.<br>
</blockquote><ol><li>Continue with installation