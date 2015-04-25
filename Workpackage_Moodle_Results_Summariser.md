# Introduction #

Perl script created by James Allen


# Details #
James' notes:

What is needed:
Simple automated ways of transforming the data that moodle can supply into useful information.
My recommendation would be a test at the start of each course to gage students initial abilities, then regular (e.g. monthly) quizes to centrally monitor progress of the course, students and facilitators.

AREA 1 - COURSE MODIFICATION AND QUESTION EVALUATION
Are the tests too hard/easy what areas are the problems in:
The simplest way to check this is to collect data as students attempt quizes and look at the average score per question.  This would generally show which questions are too easy/hard etc.
I am assuming someone or some script can log in remotely and download the moodle csv file to a given directory giving the results for each test - this is out of my area of expertise.

I am also assuming the tests keep the same questions in the same order, there is no realistic way to identify which question is which if moodles random question options are selected.

I am assuming each question is worth one mark - this assumption may be modified if I can work out how to get moodle to give me the total marks per question.

I am assuming that if a quiz is altered its name is modified or previous results from that quiz are deleted otherwise the results will be invalid.

I also assume each quiz is uniquely named.

The script that downloads the data from moodle should then call 3 perl programs
An intial processing perl which turns the data from a single class and a single quiz into a csv file.
The second perl will check if the quiz has been recorded before - if so the latest results will be added, if not a record file will be created.  This record file should show the overall results from the test and should be readable by excel. These two scripts may later be combined into 1.
The third perl program will then add the score for each student to a larger file containing each facilitator student test score.
The script can then delete or archive the downloaded data (otherwise will be overwritten when the data from the next centre/ set of students is downloaded)

There will be a perl program which will take the combined data from all centres and display it in human readable form if this is more useful than excell, there may be a second perl program which concaternates the results from several quizes into one file for easier excell viewing

FACILITATOR EVALUATION

My assumptions are the same except that:
I assume the script run earlier has already been run.
I assume the existance of a csv file associating each student with a facilitator.
When I assume that each course has an intial assesment I assume this initial assesment has a common naming convention or other distinguishing feature.  Alternatively a perl script will need to be run giving it the name of the intial test to allow it to set up the table. After this point the process should be automated and future download of a quiz file of that name will be used to update and overwrite the current table.

The output (a large table of students and test results) could be analysed directly by excell. I have no idea how to do this and I'm not sure that this is possible.
The analysis is basially
Group all students into bands based upon their intital test results. Find the average scores for each band in subsiquent testing.
Then look at the students for each facilitator, how does each students results compare to others in that band.  If they are consistantly above or below expectations, or by a large margin then it may be worth performing extra evaluation (e.g. site visit, extra training).
I will provide a perl script that will perform this analysis.