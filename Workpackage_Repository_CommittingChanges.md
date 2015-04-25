Go back to [The Repository](Workpackage_Repository.md)

# Introduction #

After you've checked out some files ([Workpackage\_Repository\_CheckingOutFiles](Workpackage_Repository_CheckingOutFiles.md)), or inserted a new project ([Workpackage\_Repository\_InsertingNewProjects](Workpackage_Repository_InsertingNewProjects.md)), the chances are that you'll want to change the files and then update the repository to share all your wonderful innovations!  This is called committing your changes.

**Please make sure that you only commit working changes to the repository.**  This will ensure that anyone who checks out the files will get a working copy of everything.

# Details #

## Preparing to commit your changes with SVN on Linux ##
Run `svn update` in the "so-class2" directory when you're ready to commit.
> This will fetch the latest code (that other people have checked in since your checkout) and alert you to any merge conflicts.

Inside the "so-class2" directory, run `svn status`.
> That will list files that have changed and files that are new (i.e., not in SVN). New files are shown with "?" in front.
For each new file or new directory, run `svn add`.
> For example `svn add the/name/of/the/FileOrDirectory` Note that adding a new directory automatically adds its files.
You might want to run `svn status` again and check that there are no unexpected files with "?" in front.

## Committing your changes with SVN on Linux ##
In the "so-class2" directory, run `svn commit -m "PROJECT: a comment to describe your changes here"`

**Please prepend the name of the project to the commit message.**
This will make it much easier to see which commit messages affected which project. Thanks.


## Committing your changes with TortoiseSVN on Windows ##
To commit your changes:

  * Right click on the "Switched On" folder (or whatever you called it when you created it before).
  * Click "SVN Update" to get any changes others have made.  This will alert you of any change conflicts.

When you're happy:
  * Right click on the "Switched On" folder (or whatever you called it when you created it before).
  * Click "SVN Commit..."
  * Type a message in the top box describing the changes that you have made.
  * Select the changes that you want to commit from the list box.  If you can't remember what the changes are, you can double click on the file to run a "diff".  _This may not be helpful for files like pictures, but it will work for text files._
  * Click Ok to commit the changes.