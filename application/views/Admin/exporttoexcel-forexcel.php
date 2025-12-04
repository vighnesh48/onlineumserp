<style>
.attexl table{
	 border: 1px solid black;
}
.attexl table th{
 border: 1px solid black;
    padding: 5px;
    background-color:grey;
    color: white;
}
.attexl table td{
	 border: 1px solid black;
    padding: 5px;
}
</style>
<?php
header('Content-Type: application/octet-stream');
header('Content-disposition: attachment; filename=export.xls');
// Fix for crappy IE bug in download.
header("Pragma: ");
header("Cache-Control: ");
echo $_REQUEST['datatodisplay'];
?>

