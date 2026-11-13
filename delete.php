<?php
require 'config.php'; 
if (!empty($_GET['id'])) {
	$file_id = mysqli_real_escape_string($conn, $_GET['id']);
	$sqlSelect = "SELECT image from file WHERE file_id=$file_id limit 1";
	$res = $conn->query($sqlSelect);
	$row = $res->fetch_assoc();

	$sql = "DELETE FROM file WHERE file_id=$file_id";
	if ($conn->query($sql) === TRUE) {
		unlink('./uploads/'.$row['image']);
		echo '<script language="javascript">';
        echo 'alert("file deleted successfully")';
        echo '</script>';
        header("Refresh:0; url=admin.php");
	} else {
		echo '<script language="javascript">';
        echo 'alert("error in deleting file")';
        echo '</script>';
        header("Refresh:0; url=admin.php");
	}
}else{
	header("Refresh:0; url=admin.php");
}
?>