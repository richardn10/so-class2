#!/usr/bin/perl
###########################################
## DifficultyOrder.pl - J. M. Allen 2009 ##
###########################################
## Given the output from a moodle quiz   ##
## this program will turn it into either ##
## human readable data or a csv file     ##
## that can be more easily compared to   ##
## rate average student performance on   ##
## any given question in the test.       ##
##                                       ##
###########################################

use strict;
my $display=0;
# Set option to display for human readout, if -d not set then program
# will output a CSV file containing the filename, number of students, 
# then alternating Queston IDS, and mean scores for that question.
if ($ARGV[0] eq "-d") {
    $display=1;
    shift @ARGV;
}
my $filename=$ARGV[0];

# Read in the question IDs and disgard unneeded information
my @questions=split /\t/, <>;
my $i=0;
while($questions[$i]!~/\#\d+/) {
    $i++;
}

# Count the students and do a running total of the scores per question. 
my $total=0;
my @answers;
while(<>) {
    $total++;
    my @scores=split /\t/,$_;
    for (my $j=$i;$j<$#questions;$j++) {
	$answers[$j]+=$scores[$j];

    }
}

# Pick display type
if ($display) {
    print "Count of students: $total";
} else {
	print "$filename,$total,";
}

# Calculate means
my %means;
for (my $j=$i;$j<$#questions;$j++) {
    my $qnum=$j-$i+1;
    my $mean=$answers[$j]/$total;
    $means{$questions[$j]}=$mean;
    if ($display) {
	print "\nQuestion $qnum: $mean";
	$means{$questions[$j]}=$mean;
    } else {
	print "$questions[$j],$mean";
	if ($j!=$#questions-1) {
	    ",";
	}
    }
} 

print "\n";
if ($display) {
    print "Questions in Order - Easiest First: \n";
    foreach my $key (sort {$means{$b} <=> $means{$a}} keys %means){
	print "$key $means{$key}\n";
    }
}
