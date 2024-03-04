<?php

   include 'db.php';

   session_start();
      
   if(isset($_GET['komentarid'])){
	  $delete = mysqli_query($conn, "DELETE FROM tb_komentar WHERE id = '".$_GET['komentarid']."' AND user_id = '".$_SESSION['id']."' ");
	  echo '<script>window.location="detail-image.php?id='.$_GET['image_id'].'"</script>';
   }

?>