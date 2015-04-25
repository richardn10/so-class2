Go back to [Video and Performance](Workpackage_VideoAndPerformance.md)

See [Installing Moodle](InstallingMoodle.md) for information on setting up Moodle on a Switched On development machine.

# Introduction #

This section details the modifications and customisation made to the moodle code to include features and functionality not available with the current release of moodle.

Some of these modifications are a bit quick and dirty and will definately need refinining.

# Modification Details #

## Adding Video ##

Added flash video player files and jquery to the 'standardwhite' theme (moodle/theme/standardwhite/flash/  ,  moodle/theme/standardwhite/js/).

Edited the moodle/theme/standardwhite/header.html file to include the javascript files (js/swfobject.js,js/jquery-1.2.6.pack.js ) and  embedded the javascript code to detect where to embed a video.

**Adding a new video**

  * Add your flv (384 x 288) to the moodle/theme/standardwhite/flash/flv/ directory
  * In the wysiwyg editor click on the html button to switch to html editing and insert the code : `<div class="so_flv" rel="myflvfile"></div>` where my flvfile is the name of your flv without the file extension.