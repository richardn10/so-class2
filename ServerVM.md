# Introduction #

Run the virtual machine inside VMWare e.g. VWware Player or VMWare Server to save installing OpenSUSE 11.2 from scratch.

# Details #

Currently we are using the image of the latest SUSE found here:

http://wwvv.quotrader.org/system/software/opensuse/112/

Please note this image may be somewhat different to the final deployment config in the following ways:
  * image uses KDE whereas I think we'll go for Gnome
    * You could test that hopefully by installing Gnome in YaST and setting it as the default desktop (pls add instructions here when you figure out how)
    * We can still include the KDE libraries in our final distribution so nothing **should** break
  * More tricky is that we probably want a 64bit version - and the 64bit versoins of some apps don't work quite as well

We can test an auto-installation process later on which should deploy your code on a machine configured as we want it.  This will require your apps and configs to be done automatically by a custom RPM (we're working on how to do this)!