<?php
    error_reporting(0);
    include 'db.php';
    session_start();
	$kontak = mysqli_query($conn, "SELECT admin_telp, admin_email, admin_address FROM tb_admin WHERE admin_id = 2");
	$a = mysqli_fetch_object($kontak);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>INSTA</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <!-- header -->
    <header class="sticky-top">
        <div class="container">
            <h1><a href="index.php">GALLERY</a></h1>
            <ul>
                <li><a href="galeri.php">Galeri</a></li>
                <?php if(!isset($_SESSION['id'])): ?>
                    <li><a href="registrasi.php">Registrasi</a></li>
                    <li><a href="login.php">Login</a></li>
                <?php endif ?>
                <?php if (isset($_SESSION['id'])) : ?>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="profil.php">Profile</a></li>
                    <li><a href="data-image.php">Image Data</a></li>
                    <li><a href="keluar.php">Logout</a></li>
                <?php endif ?>
                <li>
                    <div class="search">
                        <form action="galeri.php">
                            <input type="text" name="search" placeholder="Cari Foto" />
                            <input type="submit" name="cari" value="Cari Foto" />
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </header>

    <!-- new product -->
    <div class="section">
    <div class="container" style="width: 80%;">
       <h3>Galeri Foto</h3>
       <div class="box">
          <?php
		      if($_GET['search'] != '' || $_GET['kat'] != ''){
			     $where = "AND image_name LIKE '%".$_GET['search']."%' AND category_id LIKE '%".$_GET['kat']."%' ";
			  }
              $foto = mysqli_query($conn, "SELECT * FROM tb_image WHERE image_status = 1 $where ORDER BY image_id DESC");
			  if(mysqli_num_rows($foto) > 0){
				  while($p = mysqli_fetch_array($foto)){
		  ?>
          <a href="detail-image.php?id=<?php echo $p['image_id'] ?>">
          <div class="col-4">
              <img src="foto/<?php echo $p['image'] ?>" height="150px" />
              <p class="nama"><?php echo substr($p['image_name'], 0, 30) ?></p>
              <p class="admin">Nama User : <?php echo $p['admin_name'] ?></p>
              <p class="nama"><?php echo $p['date_created']  ?></p>
          </div>
          </a>
          <?php }}else{ ?>
              <p>Foto tidak ada</p>
          <?php } ?>
       </div>
    </div>
    </div>
    
    <!-- footer -->
     <footer>
        <div class="container">
            <small>Copyright &copy; 2024 - webinsta galeri.</small>
        </div>
    </footer>
</body>
</html>