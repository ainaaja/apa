<?php
error_reporting(0);
include 'db.php';
session_start();

$kontak = mysqli_query($conn, "SELECT admin_telp, admin_email, admin_address FROM tb_admin WHERE admin_id = 2");
$a = mysqli_fetch_object($kontak);

$foto_id = $_GET['id'];
$adminid = $_SESSION['id'];
$produk = mysqli_query($conn, "SELECT * FROM tb_image WHERE image_id = '" . $_GET['id'] . "' ");
$komentar = $conn->query("SELECT * FROM tb_komentar JOIN tb_admin ON  tb_admin.admin_id = tb_komentar.user_id where image_id = '" . $_GET['id'] . "'");

$p = mysqli_fetch_object($produk);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>INSTA</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/iconoir-icons/iconoir@main/css/iconoir.css" />
</head>

<body>
    <!-- header -->
    <header class="sticky-top">
        <div class="container">
            <h1><a href="index.php">GALLERY</a></h1>
            <ul>
                <li><a href="galeri.php">Galeri</a></li>
                <?php if (!isset($_SESSION['id'])) : ?>
                    <li><a href="registrasi.php">Registrasi</a></li>
                    <li><a href="login.php">Login</a></li>
                <?php endif ?>
                <?php if (isset($_SESSION['id'])) : ?>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="profil.php">Profile</a></li>
                    <li><a href="data-image.php">Image Data</a></li>
                    <li><a href="keluar.php">Logoutr</a></li>
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
    <?php

    if (isset($_POST['submit'])) {

        // print_r($_FILES[gambar']);
        // menampung inputan dari form
        $isi_komentar = $_POST['komentar'];
        $user_id = $_SESSION['id'];

        if (!isset($_SESSION['id'])) {
            echo '<script>window.location="login.php"</script>';
        }

        $insert = mysqli_query($conn, "INSERT INTO tb_komentar VALUES (
                                           null,
                                           '" . $user_id . "',
                                           '" . $foto_id . "',
                                           '" . $isi_komentar . "',
                                           NOW()
                                               ) ");

        if ($insert) {
            echo '<script>alert("tambah komentar berhasil")</script>';
            echo '<script>window.location="detail-image.php?id=' . $foto_id . '"</script>';
        } else {
            echo 'gagal' . mysqli_error($conn);
        }
    }
    ?>

    <!-- product detail -->
    <div class="section">
        <div class="container">
            <h3>Detail Foto</h3>
            <div class="box">
                <div class="">
                    <img src="foto/<?php echo $p->image ?>" width="100%" />
                </div>
                <div class="col-2" style="width: 100%;">
                    <div style="display: flex; justify-content: space-between;">
                        <h3><?php echo $p->image_name ?><br />Kategori : <?php echo $p->category_name  ?></h3>
                        <form action="" method="post">
                            <?php 
                            if (isset($_POST['like'])) {
                                if (!$_SESSION['status_login']) {
                                    echo '<script>window.location="login.php"</script>';
                                }
                                $like = $conn->query("SELECT * FROM tb_like where admin_id = $adminid and image_id = $foto_id");

                                if ($like->num_rows > 0) {
                                    $conn->query("DELETE FROM tb_like WHERE admin_id = $adminid AND image_id = $foto_id");
                                } else {
                                    $conn->query("INSERT INTO tb_like VALUES (NULL, $foto_id, $adminid, NULL)");
                                }
                            }
                            ?>
                            <input type="hidden" name="like">
                            <button href="" style="display: flex; gap: 5px; border: none; background: none;">
                                <?php 
                                $like = $conn->query("SELECT * FROM tb_like where admin_id = $adminid and image_id = $foto_id")->num_rows;
                                ?>
                                <i class="iconoir-heart<?= ($like > 0) ? '-solid' : '' ?>" style="font-size: 20px; color: <?= ($like > 0) ? 'red' : 'black' ?>;"></i>
                                <?php
                                $like = $conn->query("SELECT * FROM tb_like WHERE image_id = $_GET[id]");
                                echo $like->num_rows;
                                ?>
                                Like
                            </button>
                        </form>
                    </div>
                    <h4>Nama User : <?php echo $p->admin_name ?><br />
                        Upload Pada Tanggal : <?php echo $p->date_created  ?></h4>
                    <p>Deskripsi :<br />
                        <?php echo $p->image_description ?>
                    </p>
                </div>
                <div class="like">

                </div>
                <div class="komentar">
                    <h3>Komentar</h3>
                    <div>
                        <?php if ($komentar->num_rows > 0) : ?>
                            <?php while ($k = mysqli_fetch_array($komentar)) : ?>
                                <div class="isikomen">
                                    <div class="bungkus">
                                        <p>
                                            <?= $k['isi_komentar'] ?>
                                        </p>
                                        <span>-- <?= $k['username'] ?></span>
                                    </div>
                                    <div>
                                        <?php if ($k['user_id'] == $_SESSION['id']) : ?>
                                            <a href="proses-hapus-komentar.php?komentarid=<?= $k['id'] ?>&image_id=<?= $_GET['id'] ?>" onclick="confirm('Apakah kamu yakin menghapus komentar ini?')" style="color: red;">hapus</a>
                                        <?php endif ?>
                                    </div>
                                </div>
                            <?php endwhile ?>
                        <?php endif ?>
                    </div>
                    <div class="buatkomentar">
                        <form method="post" class="flex">
                            <input type="text" name="komentar" placeholder="Komentar" />
                            <input type="submit" name="submit" value="Submit" />
                        </form>
                    </div>
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