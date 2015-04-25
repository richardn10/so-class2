Go back to [Home](Home.md).

At the start of the developer weekend these wiki pages reflect Richard's requirements.  These may be modified as issues arise.  Richard will modify this text if necessary.

Please **add** detail to your team's wiki page during the developer weekend, as it will be the output documentation.  Note:
  * You may add text to this wiki (click "edit this page" link above and then see "Wiki markup help on the right").  Detailed Wiki syntax is available [here](http://code.google.com/p/support/wiki/WikiSyntax).
  * You may create new pages under this one, but please label the wiki links using the following pattern `Workpackage_WorkpackageName_YourAdditionalDescription`.  e.g. `Workpackage_VideoAndPerformance_FlippingVideoViews`
  * You may upload document files (or any other files).  Link to them from this page.  Name them `Workpackage_WorkpackageName_YourAdditionalDescription.extension` e.g. `Workpackage_VideoAndPerformance_FlippingVideoViews.doc`

Make sure only one person from your workpackage group is updating a wiki page at a time, or you'll end up overwriting each other!  To avoid this:
  * Maintain strict control to ensure only one person edits a given page at a time, or,
  * Create one or more sub-pages if you can logically split your work into sub-areas taken on by different individuals.

# Images and other files as part of deliverables #
Put images needed on your wiki pages in svn under wiki/Workpackage\_Name\_files/image.png

This is a different subversion root to the code.  It is checked out using:
  * Tortoise SVN:  https://so-class2.googlecode.com/svn/wiki/ so-wiki --username [username](username.md)
  * Command line:  svn checkout https://so-class2.googlecode.com/svn/wiki/ so-wiki --username [username](username.md)
  * No password needed for either, it seems, unless it automatically used the code subversion password

For instructions on using Subversion for the code repository, see [UsingSourceCodeRepository](UsingSourceCodeRepository.md)  (the same applies, but with a different repository root)

Add a directory called Workpackage\_Name\_files and put your files under there.
They may be included in the wiki now using:

http://so-class2.googlecode.com/svn/wiki/Workpackage_Name_files/filename

e.g. To include an image in your wiki page:

`[http://so-class2.googlecode.com/svn/wiki/Workpackage_Sponsorship_Uploads_files/SponsorshipSystemDeploymentDiagram-Production.png]`

Please do this rather than putting things in the download section of the wiki.  You work will be preserved better if kept in subversion.