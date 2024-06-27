<?php
require 'ceklogin.php';

// hitung jumlah
$h1 = mysqli_query($koneksi, "SELECT * FROM pesanan");
$h2 = mysqli_num_rows($h1);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Aplikasi Kasir</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Start Bootstrap</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Menu</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Order
                            </a>
                            <a class="nav-link" href="stock.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Stock Barang
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang Masuk
                            </a>
                            <a class="nav-link" href="pelanggan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Kelola Pelanggan
                            </a>
                            <a class="nav-link" href="logout.php">
                                <div class="sb-nav-link-icon"><i class="fa fa-sign-out"></i></div>
                                Logout
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Data Pesanan</h1>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-2">
                                    <div class="card-body">Jumlah Pesanan: <?= $h2;?> </div>
                                </div>
                                <div >
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                    Tambah Pesanan
                                </button>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3 mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Data Pesanan
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>ID Pesanan</th>
                                            <th>Tanggal Pesan</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Alamat</th>
                                            <th>Jumlah</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $getpesanan = mysqli_query($koneksi,
                                        "SELECT * FROM pesanan p, pelanggan pl WHERE p.id_pelanggan=pl.id_pelanggan");

                                        while ($p = mysqli_fetch_array($getpesanan)) {
                                            $id_pesanan = $p['id_pesanan'];
                                            $tanggal = $p['tgl_pesan'];
                                            $nama_pelanggan = $p['nama_pelanggan'];
                                            $alamat = $p['alamat'];
                                            $hitungjumlah = mysqli_query($koneksi, "SELECT * FROM detail_pesanan WHERE id_pesanan='$id_pesanan'");
                                            $jumlah = mysqli_num_rows($hitungjumlah);
                                        ?>
                                        <tr>
                                            <td><?= $id_pesanan ?></td>                                            
                                            <td><?= $tanggal; ?></td>
                                            <td><?= $nama_pelanggan; ?></td>
                                            <td><?= $alamat ?></td>
                                            <td><?= $jumlah ?></td>
                                            <td><a href="view.php?idp= <?= $id_pesanan; ?>" class="btn btn-primary" target="_blank">Tampilkan</a> | <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $id_pesanan; ?>">Delete</button></td>
                                        </tr>
                                        <div class="modal" id="delete<?= $id_pesanan; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Hapus Barang</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form method="POST">
                                                        <div class="modal-body">
                                                            Apakah Anda yakin menghapus barang ini?
                                                            <input type="hidden" name="idp" value="<?= $id_pesanan; ?>">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="hapuspesanan">Hapus</button>
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <?php 
                                            }; 
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Rangga 2024</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Data Tambah Pesanan</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
<form method="POST">
      <!-- Modal body -->
      <div class="modal-body">
        Pilih Pelanggan
        <select name="id_pelanggan" class="form-control">

        <?php
        $getpelanggan = mysqli_query($koneksi, "SELECT * FROM pelanggan");

        while($pl = mysqli_fetch_array($getpelanggan)){
            $id_pelanggan = $pl['id_pelanggan'];
            $nama_pelanggan = $pl['nama_pelanggan'];
            $alamat = $pl['alamat'];
        ?>
        <option value="<?=$id_pelanggan; ?>"> <?= $nama_pelanggan; ?> - <?= $alamat; ?></option>
        <?php    
        }
        
        ?>
        </select>
        
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" name="tambahpesanan">Simpan</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
</form>
</html>
