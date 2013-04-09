<!doctype html>
<html>
<head>
	<title>Sitemap URL Scraper</title>
	<style type="text/css">
		.inputForm {
			margin: 1em 0;
			padding: 1em;
		}
		#tblSitemap td {
			padding: 0.25em;
		}
		#tblSitemap {
			margin-bottom: 1em;
		}

	</style>
</head>
<body>

<h1>Sitemap URL Scraper</h1>
<p>A tool to parse the URLs in an XML sitemap. This only handles .XML and not .GZ</p><p> Try entering any of these sample URLs to see how it works: <br/><br/> http://www.jamesavery.com/sitemap.xml <br/>
http://www.eddiebauer.com/sitemap.xml<br/> </p>
<div class="inputForm">
<form name="frmSitemap" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<table id="tblSitemap">
<tr>
  <td id="col_1"><label>Sitemap URL:</label></td>
  <td id="col_2"><input type="text" name="url" value="" size="60"/></td>
</tr>
<tr>
  <td id="col_1">
     	
    <input type="submit" name="frmSubmit" value="Submit"/>
  </td>
</tr>
</table>
</form>

</body>
</html>

<?php


if (!isset($_POST['frmSubmit']))
  exit;
if (!isset($_POST['url']))
  die("Please enter in a URL to the sitemap to be scraped.");
$url = trim($_POST['url']);
if (strlen($url) <= 0)
  die("Please enter in a URL to the sitemap to be scraped.");
$pathParts = pathinfo($url);

// Only handles XML files. Not tar gz
if (!in_array($pathParts['extension'], array('xml')))
    die("Please enter in a XML file.");

// A better way to do this is to read in chunks
// You should schedule the operation using a cron job

// The preferredm method is to read the file in chunks
// fopen and lock the file
// You fread in n lines and when done close the file
// You keep track of line location by storing the line number in a text file
// You then open the file again and fseek to the offset
// unlock and fclose
//

// Here we do the lazy man's way of using file_get_contents
$strXml = @file_get_contents($url);
if (false == $strXml)
    die('Could not open url. Check your spelling and try again');

// So simple using SimpleXml
$sitemap = @new SimpleXmlElement($strXml);
foreach($sitemap->url as $url) {
    echo $url->loc . "<br/>";
}
file_put_contents('test.txt', $sitemap);
?>

</body>
</html>
