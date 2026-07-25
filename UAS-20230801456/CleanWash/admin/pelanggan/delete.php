<?php

require_once "../../config/auth.php";
require_once "../../config/connection.php";

if(!isset($_GET['id'])){

    header("Location:index.php");

    exit;

}

$id=(int)$_GET['id'];

$sql="DELETE FROM pelanggan WHERE id_pelanggan=?";

$stmt=$db->prepare($sql);

$stmt->execute([$id]);

header("Location:index.php?success=Data pelanggan berhasil dihapus");

exit;