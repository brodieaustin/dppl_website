#!/usr/bin/perl

use HTML::Entities ();
use CGI::Carp qw(fatalsToBrowser);

#The above line must appear as the FIRST thing in your script

#############################################################
# This snippet of code allows you to read information from a WWW form
#############################################################
$safe_chars = 'a-zA-Z0-9 ,-\/\(\)@';

($junk, $recipient, $topic) = split("/",$ENV{'PATH_INFO'});
$topic =~ s/\+/ /g;
read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
@pairs = split(/&/, $buffer);
foreach $pair (@pairs) {
	($name, $value) = split(/=/, $pair);
	$value =~ tr/+/ /;
	$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
	$value =~ s/~!/ ~!/g;
	#I added this - BA
	$value = HTML::Entities::decode($value);
	$value =~ s/[^$safe_chars]//go;
	$FORM{$name} = $value;
}
##############################################################

#############################################################
#An attempt at getting a random file name with the process ID
#############################################################

$FIZZLE = getppid;

###################################
#I always like to read in my variables next
###################################

$APPNAME = $FORM{'app-name'};
$ADDRESS = $FORM{'address'};
$APPDATE = $FORM{'app-date'};
$HOMEPHONE = $FORM{'home-phone'};
$CELLPHONE = $FORM{'cell-phone'};
$EMAIL = $FORM{'email'};

####################################

########################################
#This builds a web page on the fly as a response
########################################

print "Content-type: text/html\n\n";
#Very important first line!
print <<"PrintTag";
<html><head><style>
* {font-family: sans-serif; font-size: 9pt; margin: 0; padding: 0;}
body {width: 800px; margin: 1em; padding: 1em;}
h1 {font-size: 12pt; text-transform: uppercase; border-bottom: 1px solid \#000; padding-bottom: 15px; font-weight: bold;}
p {font-size: 8pt; margin: 15px 5px;}
table {width: 800px; border-collapse: collapse; border: 1px solid \#000; margin-bottom: 20px;}
th {width: 790px; padding: 5px; background-color: \#000; text-transform: uppercase; color: \#fff; font-weight: bold; text-align: left;}
td {vertical-align: text-top; width: 50%; height: 20px; border: 1px solid #000; padding: 5px;}
td.full {width: 790px;}
form {float: right; width: 40%;}
i {font-style: oblique;}
input {margin-left: 30px;}
</style></head><body><h1>Employment Application</h1>
<p>It is the policy of the Des Plaines Public Library to ensure equal opportunity for all individuals without regard to race, color, religion, sex, age, national origin, marital/veteran status/ disability or any other legally protected status in accordance with the requirements of local, state and federal law. Please complete all blanks or indicate \"not applicable.\" Incomplete applications may be subject to rejection.</p>
<table><thead><tr><th colspan=\"2\">Personal Information</th></tr><thead>
<tbody><tr><td>Name (First, Last, MI): <b>$APPNAME</b></td><td>Date of Application: <b>$APPDATE</b></td></tr>
<tr><td rowspan=\"3\">Current Address (include Street, City, State, and Zip Code): <b>$ADDRESS</b></td>
<td>Home Phone: <b>$HOMEPHONE</b></td></tr><tr><td>Cell Phone: <b>$CELLPHONE</b></td></tr>
<tr><td>Email Address: <b>$EMAIL</b></td></tr></tbody></table>
</body></html>
PrintTag
#######################################

########################################################################
#This part builds a file, which will eventually be used to send out as an e-mail message
########################################################################

$mailprog = '/usr/sbin/sendmail';
open (MAIL, ">/tmp/snd.$FIZZLE");
print MAIL "Content-Type: text/html\; charset=\"iso-8859-1\"\n";
print MAIL "From: $APPNAME <$EMAIL>\n";
#print MAIL "To: fschade\@dppl.org\n";
print MAIL "To: ckidd\@dppl.org\n";
print MAIL "Subject: Employment Application\n\n";
print MAIL "<html><head><style>\n";
print MAIL "body {font-family: sans-serif; font-size: 9pt; width: 100%; margin: .25em; padding: .25em;}\n";
print MAIL "h1 {font-size: 12pt; text-transform: uppercase; border-bottom: 1px solid \#000; padding-bottom: 5px; font-weight: bold;}\n";
print MAIL "p {font-size: 8pt; margin: 15px 5px; padding: 0;}\n";
print MAIL "table {width: 90%; border-collapse: collapse; border: 1px solid \#000; margin: 20px;}\n";
print MAIL "th {width: 90%; padding: 0; background-color: \#000; text-transform: uppercase; color: \#fff; font-weight: bold; text-align: left;}\n";
print MAIL "td {vertical-align: text-top; width: 50%; padding: 0; border: 1px solid #000; padding: 5px;}\n";
print MAIL "td.full {width: 90%; padding: 0;}\n";
print MAIL "form {float: right; width: 40%;}\n";
print MAIL "i {font-style: oblique;}\n";
print MAIL "input {margin-left: 30px;}\n";
print MAIL "</style></head><body><h1>Employment Application</h1>\n";
print MAIL "<p>It is the policy of the Des Plaines Public Library to ensure equal opportunity for all individuals without regard to race, color, religion, sex, age, national origin, marital/veteran status/ disability or any other legally protected status in accordance with the requirements of local, state and federal law. Please complete all blanks or indicate \"not applicable.\" Incomplete applications may be subject to rejection.</p>\n";
print MAIL "<table><thead><tr><th colspan=\"2\">Personal Information</th></tr><thead>\n";
print MAIL "<tbody><tr><td>Name (First, Last, MI): <b>$APPNAME</b></td><td>Date of Application: <b>$APPDATE</b></td></tr>\n";
print MAIL "<tr><td rowspan=\"3\">Current Address (include Street, City, State, and Zip Code): <b>$ADDRESS</b></td>\n";
print MAIL "<td>Home Phone: <b>$HOMEPHONE</b></td></tr><tr><td>Cell Phone: <b>$CELLPHONE</b></td></tr>\n";
print MAIL "<tr><td>Email Address: <b>$EMAIL</b></td></tr></tbody></table>\n";

print MAIL "</body></html>\n";

#print MAIL "<html><head><script type=\"text/javascript\" language=\"Javascript\"> <!--\n";
#print MAIL "function previewForm() {alert(\"TEST!\")\;} // --></script></head>\n";
#print MAIL "<body><img src=\"http://www.dppl.org/images/themes/River/logo.jpg\"><br><br>\n";
#print MAIL "<hr><table border=\"2\"><tr><td>a</td><td>b</td></tr></table><br>\n";
##print MAIL "<a href=\# onclick=\"javascript:previewForm();return false\;\">Preview</a><br>\n";
##print MAIL "<form><input type='button' value='Preview' onClick='previewForm();'></form><br><br>\n";
#print MAIL "Name: <b>$SUBMITTEDBY</b><br>\n\n";
#print MAIL "Recipe Name: <b>$RECIPENAME</b><br>\n\n";
#print MAIL "Ingredients: <b>$INGREDIENTS</b><br>\n\n";
#print MAIL "Directions: <b>$DIRECTIONS</b><br>\n\n";
#print MAIL "Special Notes: <b>$SPECIALNOTES</b><br>\n\n</body></html>";
close (MAIL);
#system ("$mailprog fschade\@dppl.org</tmp/snd.$FIZZLE");
system ("$mailprog baustin\@dppl.org</tmp/snd.$FIZZLE");
