<?php
session_start();
session_destroy();
header("Location: upload.php");
exit;
?>
