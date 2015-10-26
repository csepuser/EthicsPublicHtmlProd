#!/usr/local/bin/perl
##############################################################################
# TextClock                     Version 1.0.2                                #
# Copyright 1996 Matt Wright    mattw@scriptarchive.com                      #
# Created 7/15/96               Last Modified 7/15/96                        #
# Scripts Archive at:           http://www.scriptarchive.com/                #
##############################################################################
# COPYRIGHT NOTICE                                                           #
# Copyright 1996 Matthew M. Wright  All Rights Reserved.                     #
#                                                                            #
# TextClock may be used and modified free of charge by anyone so long as     #
# this copyright notice and the comments above remain intact.  By using this #
# code you agree to indemnify Matthew M. Wright from any liability that      #  
# might arise from it's use.                                                 #  
#                                                                            #
# Selling the code for this program without prior written consent is         #
# expressly forbidden.  In other words, please ask first before you try and  #
# make money off of my program.                                              #
#                                                                            #
# Obtain permission before redistributing this software over the Internet or #
# in any other medium.  In all cases copyright and header must remain intact #
##############################################################################
# Define Variables							     #

$Display_Week_Day = '1';

$Display_Month = '1';

$Display_Month_Day = '1';

$Display_Year = '1';

$Display_Time = '1';

$Display_Time_Zone = '1';

$Standard_Time_Zone = 'EST';
$Daylight_Time_Zone = 'EDT';

$Display_Link = '0';

# Done									     #
##############################################################################

@Week_Days = ('Sunday','Monday','Tuesday','Wednesday',
	      'Thursday','Friday','Saturday');

@Months = ('January','February','March','April','May','June','July',
	   'August','September','October','November','December');


print "Content-type: text/html\n\n";

if ($Display_Link != 0) {
    print "<a href=\"http://www.scriptarchive.com/\">";
}

($Second,$Minute,$Hour,$Month_Day,
$Month,$Year,$Week_Day,$IsDST) = (localtime)[0,1,2,3,4,5,6,8]; 

if ($IsDST == 1) {
    $Time_Zone = $Daylight_Time_Zone;
}
else {
    $Time_Zone = $Standard_Time_Zone;
}

if ($Second < 10) {
    $Second = "0$Second"; 
}
if ($Minute < 10) {
    $Minute = "0$Minute"; 
}
if ($Hour < 10) {
    $Hour = "0$Hour"; 
}
if ($Month_Day < 10) {
    $Month_Day = "0$Month_Day"; 
}
$Year += 1900;

if ($Display_Week_Day != 0) {
    print "$Week_Days[$Week_Day]";
    if ($Display_Month != 0) {
        print ", ";
    }
}

if ($Display_Month != 0) {
    print "$Months[$Month] ";
}

if ($Display_Month_Day != 0) {
    print "$Month_Day";
    if ($Display_Year != 0) {
        print ", ";
    }
}

if ($Display_Year != 0) {
    print "$Year";
    if ($Display_Time != 0) {
        print " - ";
    }
    elsif ($Display_Time_Zone != 0) {
        print " ";
    }
}

if ($Display_Time != 0) {
    print "$Hour\:$Minute\:$Second";
    if ($Display_Time_Zone != 0) {
        print " ";
    }
}

if ($Display_Time_Zone != 0) {
    print "$Time_Zone";
}

if ($Display_Link != 0) {
    print "</a>";
}

exit;
