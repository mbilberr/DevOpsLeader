<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Storage Management</title>
  <link rel="stylesheet" type="text/css" href="https://www.michaelbilberry.com/style/storage.css">
  <script src="https://www.michaelbilberry.com/script/sorttable.js"></script>
  <!--[if IE]><link rel="shortcut icon" href="image/icon/resume.ico"><![endif]-->
  <link rel="icon" href="../image/icon/resume.ico">
</head>

<body style="background: #ADD8E6;">
  <div style="background: linear-gradient(to bottom right, red, yellow);color:white;margin-bottom:30px;padding:10px;">
    <form enctype="multipart/form-data" action="index.php" method="POST">
      <p>Upload your file</p>
      <input type="file" name="uploaded_file"></input><br />
      <input type="submit" value="Upload"></input>
    </form>
    <form style="float:right">
      <input type=button value="Refresh" onClick="window.location.reload()">
    </form> 
  </div>

  <div id="container">
    <h1>Directory Contents</h1>
    <table class="sortable">
      <thead>
        <tr>
          <th>Filename</th>
          <th>Type</th>
          <th>Size <small>(bytes)</small></th>
          <th>Date Modified</th>
        </tr>
      </thead>
      <tbody>
      <?php
chdir(upload);
$myDirectory = opendir(".");

while ($entryName = readdir($myDirectory)) {
  $dirArray[] = $entryName;
}


function findexts($filename)
{
  $filename = strtolower($filename);
  $exts     = explode("[/\\.]", $filename);
  $n        = count($exts) - 1;
  $exts     = $exts[$n];
  $exts     = substr($exts, -3, 3);
  return $exts;
}

closedir($myDirectory);
$indexCount = count($dirArray);
sort($dirArray);
for ($index = 0; $index < $indexCount; $index++) {
  
  if ($_SERVER['QUERY_STRING'] == "hidden") {
    $hide  = "";
    $ahref = "./";
    $atext = "Hide";
  } else {
    $hide  = ".";
    $ahref = "./?hidden";
    $atext = "Show";
  }
  if (substr("$dirArray[$index]", 0, 1) != $hide) {
    
    $name     = $dirArray[$index];
    $namehref = $dirArray[$index];
    
    $extn = findexts($dirArray[$index]);
    
    $size = number_format(filesize($dirArray[$index]));
    
    $modtime = date("M j Y g:i A", filemtime($dirArray[$index]));
    $timekey = date("YmdHis", filemtime($dirArray[$index]));
    
    switch ($extn) {
      case "png":
        $extn = "PNG Image";
        break;
      case "jpg":
        $extn = "JPEG Image";
        break;
      case "svg":
        $extn = "SVG Image";
        break;
      case "gif":
        $extn = "GIF Image";
        break;
      case "ico":
        $extn = "Windows Icon";
        break;
      case "txt":
        $extn = "Text File";
        break;
      case "log":
        $extn = "Log File";
        break;
      case "htm":
        $extn = "HTML File";
        break;
      case "php":
        $extn = "PHP Script";
        break;
      case "js":
        $extn = "Javascript";
        break;
      case "css":
        $extn = "Stylesheet";
        break;
      case "pdf":
        $extn = "PDF Document";
        break;
      case "zip":
        $extn = "ZIP Archive";
        break;
      case "bak":
        $extn = "Backup File";
        break;
      default:
        $extn = strtoupper($extn) . " File";
        break;
    }
    
    if (is_dir($dirArray[$index])) {
      $extn  = "&lt;Directory&gt;";
      $size  = "&lt;Directory&gt;";
      $class = "dir";
    } else {
      $class = "file";
    }
    
    if ($name == ".") {
      $name = ". (Current Directory)";
      $extn = "&lt;System Dir&gt;";
    }
    if ($name == "..") {
      $name = ".. (Parent Directory)";
      $extn = "&lt;System Dir&gt;";
    }
    
    print("
          <tr class='$class'>
            <td><a href='upload/$namehref'>$name</a></td>
            <td><a href='upload/$namehref'>$extn</a></td>
            <td><a href='upload/$namehref'>$size</a></td>
            <td sorttable_customkey='$timekey'><a href='upload/$namehref'>$modtime</a></td>
          </tr>");
  }
}
?>
    </tbody>
    </table>
    <h2><?php
print("<a href='$ahref'>$atext hidden files</a>");
?></h2>
  </div>

<?PHP
if (!empty($_FILES['uploaded_file'])) {
  $path = $path . basename($_FILES['uploaded_file']['name']);
  if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
    echo "The file " . basename($_FILES['uploaded_file']['name']) . " has been uploaded";
  } else {
    echo "There was an error uploading the file, please try again!";
  }
}
?>

</body>
</html>
