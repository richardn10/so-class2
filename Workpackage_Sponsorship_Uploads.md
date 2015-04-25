Go back to [Workpackages](Workpackages.md).

# Introduction #
Read WorkpackageDocumentationInstructions

# Requirements / Solution Outline #

## The problem ##
Need to upload photos and videos of Switched On sponsored students to the Switched On web server and YouTube respectively.
The bandwidth in the training centres can be low and the network and electricity supply highly unreliable.  Yet we need to make good use of the administrator's time so the Coms Admin cannot sit endlessly pressing the send button.  There may be 50 student profiles with photos and videos to create and upload, and we need to pay them for their time... (gasp!  yes, there are similarities between me and Scrooge for any not acquainted with my Yorkshire ways!)

The users are largely tech un-savvy.  We need to reduce maintenance time as much as possible, so the code needs to be (or become as we improve it) robust with error-handling etc.

Furthermore, it needs to integrate with our Intalio business process.

## Proposed solution ##

There are 5 components of the system (see deployment diagram at bottom):
  * Intalio workflow/business process engine (Richard setting up with free help from a kind company called MphasiS).  Interaction via web, RESTful web services
  * Switched On FTP server for storing photos
  * YouTube for hosting videos
  * Receiving the file to upload:  PHP running in Apache on the Training Centre Server (in the Switched On training centre) - to be called from a link in an Intalio page that will then receive the file location (video or photo) and store it for the PHP scheduled script (below)
  * Uploading the file:  Sceduled PHP script (Windows at this stage though Linux later!) to process files and upload them reliably in the background, and reliably notify Intalio when completed

![http://so-class2.googlecode.com/svn/wiki/Workpackage_Sponsorship_Uploads_files/SponsorshipSystemDeploymentDiagram-Production.png](http://so-class2.googlecode.com/svn/wiki/Workpackage_Sponsorship_Uploads_files/SponsorshipSystemDeploymentDiagram-Production.png)

**Deployment Architecture**
This shows the components relevant to this workpackage in the context of the system current architecture for the sponsorship programme.

## Training Centre Server Scripts and Interation with the Business Process Management Server ##

### Receiving the file to upload ###
Comms Admin user selects file to upload and file gets put in processing queue for upload.

The file is uploaded from the Intalio BPMS-served page and communication goes to the Switched On Server app and back to the Intalio page as per the following diagram.

![http://so-class2.googlecode.com/svn/wiki/Workpackage_Sponsorship_Uploads_files/ss_file_upload_windows.png](http://so-class2.googlecode.com/svn/wiki/Workpackage_Sponsorship_Uploads_files/ss_file_upload_windows.png)

The upload process on the Training Centre ( local ) Server is called the **Switched On User Agent, or SUA**.

Note, the URL of the upload agent page (loaded in the iframe) comes from the Business Process Server database as a user option.  If the database entry does not exist or does not work, the following default should be used:
"http://localhost/sponsorship/uploads"
If that page does not exist, the following text should be displayed:
"The local Upload page cannot be found.  You need to know the address of the agent used to upload your files.  It can be set using the "User Options" process.  Contact the Switched On administrator/manager if you cannot successfully set this."

The steps of the process, focusing mainly on the Switched On Server Upload application, though it shows how it integrates with the Intalio Business Process:

  * Web page served to our Communications Administrator by Intalio as part of some wider process (Comms Admin enters student profile, messages, photos and video in the Switched On training centres.  These will be used in comms with sponsors.)  A given web page will include a section to upload photos and/or video.  The upload interaction point is a button on the page that opens an iframe in a modal window with a URL and get string to pass info to the locally hosted apache along the lines:

```
http://socs/sponsorship/uploads?attName={string}&batchid={short_number}&filetype={image|video}&corrid={string}
&tstamp={yyyymmdd-hhmm}&token={SHA-256, see text}
```


These are:
  * socs is some identifier, here standing for Switched On Centre Server)
  * attName = Attachment name.  All these files are attachments to messages, profile pages.  This name is unique to the batch e.g. "profile\_photo" or "full\_body\_photo".
  * filetype - determines what type of store to be put on
  * corrid = correlation id, used by Intalio to identify the process instance handling the upload of the files (i.e. tracking them)
  * tstamp = timestamp, for use in verifying the security token
  * token = security token.

When the upload form is started 2 parameters enable security, namely a timestamp and a verification token. The verification token is made by taking a SHA-256 of the concatenation of a secret string (to be shared privately), timestamp, the correlation id (for the Intalio process) and the text "INTALIOTOUPLOADAPP".

  * The Comms Admin clicks this link and a new browser window opens that asks the user to browse for the photo using an input field:


&lt;input type="file" name="somename" size="40"&gt;


The file should be submitted to the local Apache server using the submit button (though it is local, this will allow us to host the file processing component on another machine in the network in the future).
  * Naming of files:The local server renames the file to: "eight random alphanumeric characters".jpeg/gif/png (ending the same as the uploaded file) and saves it in a local folder.  (note the filename is assigned by this app or the service the file is uploaded to.  This is necessary in the case of YouTube.)
  * Naming videos -
  * The local server also appends the correlation\_id, file-type and photo\_id in a local "work-log" (MySQL database table(s)), to be processed by the PHP Windows Service (Linux daemon in future!)
  * The modal window closes and the user can continue entering student profile info in the Intalio service whilst the server is busy processing and uploading files in the background.   The intalio server will be waiting for a notification at some stage that the file has been successfully uploaded before sending an email to the sponsor containing links to the photos and video (see below)

### Uploading the file ###
**PHP regularly scheduled task processes and uploads from the file queue**

  * Reads next (top) entry in the work-log table(s) (see above) - including filename and correlation\_id.  If there are no more items in the worklog, go to sleep for 2 mins and then check again.
  * If is a video
    * Compresses the video to flash format .flv (bandwidth can be low) to make it significantly smaller.  Recommend use the utility ffmpeg  (www.ffmpeg.org), naming it with the same filename except with the .flv extension
    * Upload it to YouTube using the Direct Upload API documented at: http://code.google.com/intl/en/apis/youtube/2.0/developers_guide_php.html#Direct_Upload
    * Test that upload is successful.  If fails, try again two more times.  Log every attempted upload, with start and end times and success/failure.
    * Invoke Intalio to notify of success/failure, passing (genericised for video and images).  This should be done via a RESTful web service (remember that there could be a power cut at any moment!):
      * attName
      * corrid={long\_number} - so Intalio knows which process the file upload corresponds to
      * filename (as generated by YouTube or the app in the case of an image upload)
      * resource store {YouTube|SOWeb}
      * tstamp={yyyymmdd-hhmm}
      * token=SHA-256 of the concatenation of a secret string (to be shared privately), timestamp, the correlation id and the text "INTALIOTOUPLOADAPP".
      * error message - Textual (Null if success)
      * retry attempt number - number of upload re-starts or resumes
    * Also upload the compressed video to the Switched On FTP server as a backup (but have a config file that allows to turn this feature off).
    * Question: given the unreliability apparently of the network in the slum area, any idea if YouTube allows file transfer to continue if the network transfer is interrupted?
  * If is an image
    * Compress the image to 200px wide (retaining aspect ratio).  Upload both it and the original, but call the compressed version - filename-200px.file-extn.  [requirement as found there is a need to be able to review compressed versions on images in the Intalio processes.](new.md)
    * For the slightly more adventurous: Check if there were previous attempts to upload the file (there may have been a powercut so the file at the top of the work-log may already be partly uploaded) and append the rest of the file if the APPE command or equivalent is available in PHP.  Otherwise, just re-attempt and write over.
    * Upload the image and its compressed version via FTP to the Switched On server (FTP details will be given).
    * Resiliency: if fails, re-attempt, appending or overwriting if you prefer.  Log all attempts, successful or failed.
    * Invoke Intalio to notify of success/failure as for video.
  * Move the file to a processed and uploaded file (in case of the video, just keep the original file, not the flv)
  * Remove entry from top of work-log and add to it to a process files log, along with the time was uploaded time.
  * Go back to step 1.

Note the Upload Agent continually retries if necessary.  It will be stopped only by manual intervention through the status page.  The com admin/area manager will be notified via the Business Process Server of problems, so they can intervene.

### Deleting files ###
This web service is to reside on the BPMS server, but written in PHP (or similar), not as a Business Process, and will delete uploaded files (e.g. if uploaded by mistake).  Takes array of idss\_Att values to read the necessary details to be able to delete the file from ss\_Att  ( using sileid and resource store {YouTube|SOWeb} ).  Deletes the rows from ss\_Att once files removed.

Exposes RESTful interface "BatchDeleteUploadedFiles"

Needs return error if fails to delete.  Only leaves orphaned files, not a major issue.

### Reporting error ###
If the upload process encounters an error, it should be reported to the same RESTful interface as the successful uploads on the business process server ( see above ).


Security credentials not needed as will be on secured machines and network.

### Status of uploads ###
  * Page to indicate upload status, including any errors encountered, retry attempt number
  * Ability to cancel a certain file upload - password protected so only the AreaManager can do this (has the ability to wreak havoc with the process if wrong files deleted)
  * Shortcut on desktop to open this page

### Installation ###
(can come later)
Windows initially, SUSE Linux later.
  * Ideally a script to auto-install and configure
  * Apache & MySQL should run as services
  * Scheduled / cron job should run automatically so uploads will occur automatically
  * Shortcut on desktop to uploads status

### Future Requirements ###
We will probably want to use it to upload other files, such as logs and student work for assessment.


# Discussion record #
Can see in full in the google group.

---

Peter Smit:

I would not have any requirements for later integration (with SUM workpackage), except that if a nice Zend Framework structure would be used it is later trivial to integrate it in one application tree. So complete ZF would be nice, but is of course not necessary. And if we need some php extensions later, it will be easy to install that package, without affecting anything else.

---

Richard to Peter Smit:

Given your comment about messaging, I now recommend using a database because:

1. I'd rather move to messaging (Zend\_Queue using Apache ActiveMQ) at some future point if  not right from the start, to cope with network and server outages.
2. Messaging could also reduce the coding we need to do, as it will schedule work automatically coming to/from the main Switched On Intalio server (BPMS)
3. I expect we'll put it on the same server as SUM (Switched On User Management) at some point soon, and SUM needs a database anyway.


Question:

2. Would there be benefit in using the queue to manage the uploads?  i.e. the PHP page that uploads the files to the local Switched On training centre server saves the file, compresses it if need be, and pops it on a message queue to be processed...

---

answer and reply:

Pete,

1. I don't know exactly the essentials of ActiveMQ, for example the
persistence with server outages (is the queue stored on disk?). The
advantage of using Zend\_Queue is that it doesn't matter. Just one line
of code change (or configuration file) and another type of queue is
used

I zeroed in on this because ActiveMQ is supported by Zend\_Queue and is an implementation of JMS, which is necessary for compatibility with Intalio.  I believe ActiveMQ uses MySQL for persistence.  I may have misunderstood something though as I had only a cursory look.

2. We are using MySQL for SUM. Sqlite is a server/fileformat that can
be accessed with sql-like statements. (sqlite.org). I think that MySQL
is the easiest.

MySQL it is then.


---


# Team documentation #

[Sponsorship Uploads Implementation](Workpackage_Sponsorship_Uploads_Implem.md)


---


# Workpackage Team Members #
  * To be grabbed - If no takers, Peter Smit will take up in the New Year