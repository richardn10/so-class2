Go back to [The Repository](Workpackage_Repository.md)

# Introduction #

If you've been working on a new project, or a new section of a project, you will eventually want to insert it into the repository so that it can be shared with everyone and you can keep track of versions.

# Details #

## Inserting a new project with SVN on Linux ##

  * Log into http://code.google.com/p/so-class2/source/checkout and make a note of the username on the end of the top of the two examples _the one that has `https://` not `http://`_ (if there's only one example, you've not yet logged in).

  * Go to the folder where your main project folder is.  (eg. If your main project is a folder called `lessons` and this is in your `docs` folder, go into the `docs` folder).

  * Type `svn import lessons https://so-class2.googlecode.com/svn/trunk/lessons -m "LESSONS: First Import"`  Change the message to reflect the project more accurately.

  * If you're asked for your password, you can click "googlecode.com password" on the googlecode page to get your Google Code password)

This will create a directory under your current directory called so-class2 with all the files in it.




## Inserting a new project with TortoiseSVN on Windows ##

  * Go to the folder where your main project folder is.  (eg. If your main project is a folder called `lessons` and this is in your `Documents` folder, go to the `Documents` folder).
  * Right click on the folder (`lessons` in this example) and a menu will come up
    * click the `TortoiseSVN` menu item
    * click the `Import...` menu item
> > > In the "URL of repository" box, type:
> > > `https://so-class2.googlecode.com/svn/trunk/lessons/`
> > > Replace the word `lessons` with the actual name for your project.  Don't forget to have a `/` on the end!
    * Type in a message describing the project you are inserting
    * Click OK

  * If prompted for your username and password, enter the details you find here (you'll need to log in to google for this):

> http://code.google.com/p/so-class2/source/checkout


> (Click "googlecode.com password" to get your Google Code password)