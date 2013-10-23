<?
include "config.php";

function gather_ip(){
   global $server, $port, $user, $passwd, $tag, $filestore;

   $connect = "{$server/imap/notls:$port}INBOX";
   if ($mbox = imap_open($connect, $user, $passwd, OP_READONLY))
   {
      $nb_msg = imap_num_msg($mbox);

      for ($msgid = 1; $msgid <= $nb_msg; $msgid++)
      {
         $o = imap_headerinfo($mbox, $msgid);

         if ($o->Unseen == 'U' || $o->Recent == 'N')
         {
            if (strpos($o->subject, '[$tag]') == 0) { // hard-coded tag
               mkdir($filestore, 0777, true);

               $fp = fopen($filestore . substr($o->subject, strlen($tag) + 2), "w+");
               fwrite($fp, imap_body($mbox, $msgid));
               fclose($fp);
               imap_setflag_full($mbox, $msgid, "\\Seen");
            }
            else {
               imap_delete($mbox, $msgid); // SPAM
            }
         }
      }
      imap_close($mbox, CL_EXPUNGE);
      return;
   }

   return imap_last_error();
}

gather_ip();
?>
