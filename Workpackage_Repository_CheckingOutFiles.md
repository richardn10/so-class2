Go back to [The Repository](Workpackage_Repository.md)

# Introduction #

Now that you have subversion on your computer (if you don't, read [Workpackage\_Repository\_InstallingSVN](Workpackage_Repository_InstallingSVN.md)), you may want to have a look at all the files everyone has been creating.  You do this by getting a copy of the files from the repository.  This is simple, and is called Checking Out the files.

# Details #

## Checking out the Switched On files with SVN on Linux ##

  * Log into http://code.google.com/p/so-class2/source/checkout and copy the top of the two examples **the one that has `https://` not `http://`** (if there's only one example, you've not yet logged in).

  * If you're asked for your password, click "googlecode.com password" on the googlecode page to get your Google Code password)

This will create a directory under your current directory called so-class2 with all the files in it.


## Checking out the Switched On files with TortoiseSVN on Windows ##

To get the Switched On files to your computer, you need to "check them out" of the repository.  To do this:

  * Create a new folder anywhere on your computer (perhaps in Documents).
  * Call the new Folder "Switched On" (this actually can be whatever you like).
  * Right click on your new folder and a menu will come up
    * click the SVN Checkout... menu item
> > > In the "URL of repository" box, type:
> > > `https://so-class2.googlecode.com/svn/trunk/`
> > > (if you want you can replace `trunk/` with a branch or tag version you want to use, but if you don't know what this is, leave it as `trunk/`)


> You can either select "HEAD revision" to get the latest version with all changes, or you can enter a revision number to get a particular revision (click "Show Log" to see the revisions)
  * Click OK

  * If prompted for your username and password, enter the details you find here (you'll need to log in to google for this):
> http://code.google.com/p/so-class2/source/checkout


> (Click "googlecode.com password" to get your Google Code password)