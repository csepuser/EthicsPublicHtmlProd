<?
/*
PHP Guestbook
Written by Tony Awtrey
Anthony Awtrey Consulting
See http://www.awtrey.com/support/dbeweb/ for more information

1.1 - Oct. 20, 1999 - changed the SQL statement that reads data
      back out of the database to reverse the order putting the
      newest entries at the top and limiting the total displayed
      by default to 20. Added the ability to get the complete list
      by appending the URL with '?complete=1'. Added the code and
      additional query to count and list the total number of entries
      and included a link to the complete list.
1.0 - Initial release

This is the SQL statement to create the database required for
this application.

CREATE TABLE guests (
  guest_id
    int(4)
    unsigned
    zerofill
    DEFAULT '0000'
    NOT NULL
    auto_increment,
  guest_name varchar(50),
  guest_email varchar(50),
  guest_time timestamp(14),
  guest_message text,
  PRIMARY KEY (guest_id)
);

*/
////////////////////////////////
// This checks to see if we need to add another guestbook entry.
////////////////////////////////
if (($REQUEST_METHOD=='POST')) {
////////////////////////////////
// This loop removed "dangerous" characters from the posted data
// and puts backslashes in front of characters that might cause
// problems in the database.
////////////////////////////////
for(reset($HTTP_POST_VARS);
                      $key=key($HTTP_POST_VARS);
                      next($HTTP_POST_VARS)) {
    $this = addslashes($HTTP_POST_VARS[$key]);
    $this = strtr($this, ">", " ");
    $this = strtr($this, "<", " ");
    $this = strtr($this, "|", " ");
    $$key = $this;
  }
 ////////////////////////////////
  // This will catch if someone is trying to submit a blank
  // or incomplete form.
  ////////////////////////////////
  if ($name && $email && $message ) {
   ////////////////////////////////
    // This is the meat of the query that updates the guests table
    ////////////////////////////////
    $query = "INSERT INTO guests ";
    $query .= "(guest_id, guest_name, ";
    $query .= "guest_email, guest_time, guest_message) ";
    $query .= " values(0000,'$name','$email',NULL,'$message')";
    mysql_pconnect("db2.pair.com","tator_w","password")
                   or die("Unable to connect to SQL server");
    mysql_select_db("tator_awtrey") or die("Unable to select database");
    mysql_query($query) or die("Insert Failed!");
	} else {

    ////////////////////////////////
    // If they didn't include all the required fields set a variable
    // and keep going.
    ////////////////////////////////
    $notall = 1;

  }
}
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<!-- Let them know that they have to fill in all the blanks -->
<? if ($notall == 1) { ?>
<P><FONT COLOR="red">Please answer all fields</FONT></P>
<? } ?>
<!-- The bits of PHP in the form allow the data that was already input
     to be placed back in the form if it is filled out incompletely -->

<FORM METHOD="post" ACTION="guest.php">

Your Name:       <INPUT
                     TYPE="text"
                     NAME="name"
                     SIZE="20"
                     MAXLENGTH="50"
                     VALUE="<? echo $name; ?>">
Your Email:      <INPUT
                     TYPE="text"
                     NAME="email"
                     SIZE="20"
                     MAXLENGTH="50"
                     VALUE="<? echo $email; ?>">

Enter Message:
<TEXTAREA NAME="message" COLS="40" ROWS="8" WRAP="Virtual">
<? echo $message; ?>
</TEXTAREA>

<INPUT TYPE="submit" VALUE="Add">
</form>
</body>
</html>