Go back to [Workpackages](Workpackages.md).

# Introduction #
Read WorkpackageDocumentationInstructions

# Requirements #
For all Switched On code and configs for the central server to be installed automatically through the RPM mechanism.

## Initial work ##
  * A couple of Switched On work-packages/projects packaged as RPMs, with mechanism to re-create the RPMs using a Switched On script if changes occur.
  * The script should ideally pull the source from the Google subversion repository using particular version labels on a per-package basis.  We could do with some instructions on how to apply labels in this way.
  * A "Super RPM" to install all Switched On RPMs, and a script to re-create this RPM when there are changes to the list of Switched On RPMs.
  * Expect there to be no compilation requirements at this stage
  * the RPMs should install on any architecture (e.g 64/32 bit)
  * Currently for OpenSUSE 11.2 (but will move to higher versions)
  * Set up Switched On YUM repository and have instructions and scripts to upload RPMs to here.

## Future envisaged work ##
  * To enable customised installations: one RPM may ask for initial info detailing parameters specific to the particular training centre that could be utilised by subsequently installed SO RPMs.
  * Got Autoinstall working using Autoyast which would itself use the Switched On YUM repository.

# Team documentation #
Please add pages for
...

# Workpackage Team Members #
  * Peter Thorpe
  * Adam Bewsher (on SO autoinstall at a later stage)