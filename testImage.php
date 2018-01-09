
<!DOCTYPE html>
<html>
<head>
    <title>Upload Files using normal form and PHP</title>
</head>
<?php
$editFormAction = $_SERVER['PHP_SELF'];

if(isset($_FILES['fileToUpload'])){
    include 'up.php';
}
?>

<body>
  <form enctype="multipart/form-data" method="post" action="<?php echo $editFormAction; ?>">
    <div class="row">
      <label for="fileToUpload">Select a File to Upload</label><br />
      <input type="file" name="fileToUpload" id="fileToUpload" />
      <input type="text" name="patient_no" />
      <input type="submit" value="Upload" />
    </div>
  </form>
</body>
</html>
