<html>
<head>
<title>Gathering IP</title>
</head>
<body>
<?
include "config.php";

function gather_ip(){
   global $server, $port, $user, $passwd, $tag, $filestore;

   $connect = "{" . $server . "/imap/notls:" . $port . "}INBOX";
   if ($mbox = imap_open($connect, $user, $passwd, CL_EXPUNGE))
   {
      $nb_msg = imap_num_msg($mbox);

      print "<ul>\n";
      for ($msgid = 1; $msgid <= $nb_msg; $msgid++)
      {
         $o = imap_headerinfo($mbox, $msgid);

         if ($o->Unseen == 'U' || $o->Recent == 'N')
         {
            print "<li>" . $o->subject;

            if (strpos($o->subject, '[$tag]') == 0) { // hard-coded tag
               mkdir($filestore, 0777, true);

               $fp = fopen($filestore . substr($o->subject, strlen($tag) + 2), "w+");
               fwrite($fp, imap_body($mbox, $msgid));
               fclose($fp);
            }
            else {
               print " <b>SPAM!!</b>";
               imap_delete($mbox, $msgid); // SPAM
            }
            print "</li>\n";
         }
      }

      $range = "1," . imap_num_msg($mbox);
      print "</ul>\nSetting as Seen: $range";
      imap_setflag_full($mbox, $range, "\\Seen");
      imap_close($mbox);
      print "<br/>Done.";
      return;
   }

   return imap_last_error();
}

gather_ip();
?>
</body>
</html>
