<?php

require_once "../../config/auth.php";
require_once "../../config/helper.php";
require_once "../../config/connection.php";

if(!isset($_GET['id'])){

    header("Location:index.php");
    exit;

}

$id = intval($_GET['id']);

$sql = "

DELETE FROM layanan

WHERE id_layanan=?

";

$stmt = $db->prepare($sql);

$hapus = $stmt->execute([$id]);

if($hapus){

    header("Location:index.php?success=Data layanan berhasil dihapus");

}else{

    header("Location:index.php?error=Data layanan gagal dihapus");

}

exit;

?>