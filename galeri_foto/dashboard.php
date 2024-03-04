<?php
    session_start();
	if($_SESSION['status_login'] != true){
		echo '<script>window.location="login.php"</script>';
    }
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
    
    <!-- content -->
    <div class="section">
        <div class="container">
            <h3>Dashboard</h3>
            <div class="box">
                <h4>Selamat Datang <?php echo $_SESSION['a_global']->admin_name ?> di Website Galeri Foto</h4>
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