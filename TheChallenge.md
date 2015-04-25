Go back to [Home](Home.md).

# Scenario #

The setting is a computer training centre in Kotwali village, Malda, West Bengal, India.

Eight students are filing into the centre for a lesson in basic office application skills, led by a virtual teacher and a real facilitator.

At the reception desk, they each pay for the lesson, with the facilitator being notified of the charge for each on the reception computer as he selects the students' names one by one.  The students pay on a lesson-by-lesson basis because this matches their families' cash-flow better than paying up-front.  The facilitator takes 10Rs from seven, but 5Rs from one for whom a concession has been agreed in advance.  If a student pays a different amount (less due to financial difficulty or more to compensate for shortfalls) then the facilitator must record this.  The computer records each transaction irrevocably, as a disincentive for corruption.  The facilitator actually has to add one of the students into the centre's Switched On computer database because she is new.  She also needs to be entered into the classroom management system, which uses a software package called Moodle (see www.moodle.org).

The seven existing students are already assigned to groups in a database running on a server in the computer centre.  The facilitator directs each group to its own computer (or terminal).  For practical reasons, these three computers are located within a single cubicle so the students can all hear the virtual teacher and each other, but are not too disturbed by other students (or vice-versa).  The facilitator assigns the new student to an existing group of two, such that there are now two groups of three and one pair.  This is recorded in the Switched On database.

The facilitator assigns one of the groups to be the lesson controller.  When the "controller" group plays the virtual teacher video clips on its computer by clicking on a web page, the video clips play in synchronicity on the other two computers (but on no other computer).  This means the groups all watch the virtual teacher together and can all "participate" in unison with the virtual class.  In-between clips from the virtual classroom, the groups work at their own pace on the computer-based exercises.  Alternatively, they may undertake peer-group activities such as discussions or exercises with physical materials provided by the facilitator.  The facilitator will guide the activities and playing of the classroom videos, taking queues from their course facilitator handbook and the particular needs of the students.  For example, the facilitator may start the first few lesson clips and then hand over to the controller group once it gets the hang of it, help the students as they attempt to format an Office document, and provide feedback to the whole group at the end of certain exercises.

Before the lesson starts, the students one-by-one register at their terminal by entering each his or her name and typing a private password.  Each is asked by the computer to confirm the number of Rupees they paid for this lesson as entered by the facilitator into the Switched On database, and to correct it if necessary.  This cross-check will encourage honesty.  Note that this is not the same as the students logging in.  The group logs in to Moodle by entering a group username and password.  The computer's ID, group ID, student IDs, course, lesson number and date/time are all recorded and associated in the Switched On database.  These data can be viewed via a Web page by the facilitator and other trainers or assessors.  Students will be encouraged to register at each lesson by a minumum lesson attendance criteria for passing the course.

The course presentation is controlled by Moodle and does not need to be modified during this developer weekend to fit in with the Switched On approach, except for a couple of aspects.  The course consists of a set of lessons on a Moodle web page.  The lessons each comprise a set of links under each other and students have to click on the links in sequence to follow the lesson.  So far, this is all handled by Moodle.  Some of the links play videos of the virtual class.  Moodle needs to be modified such that only the controller group can activate these video links and that the video plays automatically and synchronously on all PCs that are part of the lesson.  Whilst being played, other activities on each PC are suspended and resumed when the clip stops.  The sound component of the video should also play on each client (student) computer.

Each video clip plays in two modes, which it flicks between automatically as directed by metadata encoded into the clip (assume use of Adobe Permiere Elements proprietary extensions).  The first mode is where the video window is large and there is no associated slide (image).  The second mode has a smaller video window and a slide (image) next to it.  The large video size is useful for drawing students into the virtual classroomm experience or communicating the virtual teacher's body language clearly.  The second mode is useful for allowing students to see things such as the white board or a picture.  The second mode could have the important added advantage of minimising video file size and network use whilst not compromising perceived quality.

The (sample 10-20 minute) lesson uses the two video modes, cuts between shots of the virtual teacher and virtual students and has a video recording of an activity performed on a computer.  It also consists of multiple short clips interleaved by exercises.

Twenty-five minutes after the lesson started, a five minute warning flashes on the screens and the students are automatically logged out of Moodle and/or the computer after half-an-hour (in reality lesson length is likely to be 1-2 hours).

After the lesson, the groups log out (or are automatically logged out) and the logout time is recorded in the Switched On database.

One of the students then pays a further amount, registers on a PC and logs in to Moodle on their own to undertake an individual exercise, which is a requirement to complete at some point during the course.  The registration password and the Moodle password are the same (i.e. they should both use the Moodle password database).  They are presented with a different page from the group Moodle page, which contains just the instructions and exercises necessary for them to complete their personal work.  He or she has the ability to play any video clip presented, and this does not force them to be played on any other PC.  The facilitator is on hand to help if necessary.  Again the student is logged out automatically (after a warning) once the period the student paid for us up.

This scenario actually begins with configuring the computer system and installing the lesson.  A script us run on a development server in the Switched On Malda HQ.  This pulls the software artefacts for installing and configuring the system out of a source code repository and builds a directory tree from which installation is performed.  This tree is burned to a CD.  The CD is run after a standard Gnome installation of OpenSUSE 11.1 on a Switched On Training Centre server.  Once the setup CD has been run, a Switched On configuration tool is started on the system that installs the Switched On and Moodle databases (containing existing users and course materials).  As a separate step, the video and other multimedia artefacts are installed through this same tool, though they are pulled off a DVD already created by the lesson department.

The scenario ends with an assessor logging into Moodle and noting student attendance, payments and performance.  The assessor also infers strengths and weaknesses in the course materials and the facilitator.  Note that Moodle already provides both summaries and detailed results for the computer-based exercises.

Extra notes:
  1. The Moodle interface should be customised through style-sheets and graphics.  The configuration tool should also be professional and attractive.  Animated effects may be added to increase the feel of quality and create a good experience.  The Switched On branding should be applied throughout.
  1. It's not that bad!  Some members have been discussing how to do this.

# Workpackages #

Click [here](Workpackages.md) to see details of the Workpackages in this project.

# Technical setup #
  * Central server running OpenSUSE 11.1 x86 i586
  * Student computers to run Firefox web browser (2+) and IE (6+) with Flash player.
  * Moodle uses: MySQL backend, Apache, PHP