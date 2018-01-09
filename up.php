<?php
if(isset($_POST['me']))
{include 'ImageManipulator.php';
    $validExtensions = array('.jpg', '.jpeg', '.gif', '.png');
    $fileExtension = strrchr($_FILES['fileToUpload']['name'], ".");
    echo "test reaching";
    if (in_array($fileExtension, $validExtensions)) {
        $newName = $_POST['patient_no'] . $_FILES['fileToUpload']['name'];
        $destination = 'uploads/' . $newName;
       move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $destination);
            
    }
    
}
?>
