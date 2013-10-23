<html>
<head>
<title>Dynamic IP</title>
</head>
<body>
<h1>Dynamic IP</h1>
<?
include "config.php";

function display_ip() {
   global $filestore;

   $entries = glob("$filestore/*", GLOB_MARK);

   if (count($entries) == 0) {
      print "<i>No dynamic IP found.</i>\n";
   }
   else {
      print "<ul>\n";
      foreach ($entries as $entry) {
         if (substr($entry, -1) != '/') { // regular file
            $data = file_get_contents($entry);
            print "<li><b>" . basename($entry) . "</b><br>\n<pre>\n$data\n</pre>\n</li>\n";
         }
      }
      print "</ul>\n";
   }
}

display_ip();
?>
</body>
</html>
