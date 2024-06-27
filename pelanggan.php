<?php
require 'ceklogin.php';
$pelanggan = mysqli_query($koneksi, "SELECT * FROM pelanggan");
$h2 = mysqli_num_rows($pelanggan);

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
                        <h1 class="mt-4">Kelola Pelanggan</h1>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-2">
                                    <div class="card-body">Jumlah Pelanggan : <?= $h2;?> </div>
                                </div>
                                <div >
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                    Tambah Pelanggan
                                </button>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3 mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Data Pelanggan
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th> No </th>
                                            <th>Nama Pelanggan</th>
                                            <th>No Telpon</th>
                                            <th>Alamat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($pelanggan as $pl) : ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= $pl['nama_pelanggan']; ?></td>
                                            <td><?= $pl['notelp']; ?></td>
                                            <td><?= $pl['alamat']; ?></td>
                                            <td>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $pl['id_pelanggan'];?>">Edit</button> |
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $pl['id_pelanggan'];?>">Delete</button>
                                            </td>
                                        </tr>
                                        <!-- Modal Edit--> 
                                        <div class="modal fade" id="edit<?= $pl['id_pelanggan'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Ubah<?= $pl['nama_pelanggan']; ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <form action="" method="post">

                                            <div class="modal-body">
                                            <input type="text" name="nama_pelanggan" class="form-control" placeholder="Nama Pelanggan" value="<?= $pl['nama_pelanggan']; ?>">
                                                    <input type="text" name="notelp" class="form-control mt-2" placeholder="No. Telp" value="<?= $pl['notelp']; ?>">
                                                    <input type="text" name="alamat" class="form-control mt-2" placeholder="Alamat" value="<?= $pl['alamat']; ?>">
                                                    <input type="hidden" name="idpl" value="<?= $pl['id_pelanggan']; ?>">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success" name="editpelanggan">Submit</button> 
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>

                                            </form>

                                            </div>
                                        </div>
                                        </div>

                                        <!-- Modal Delete-->
                                        <div class="modal fade" id="delete<?= $pl['id_pelanggan'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Hapus <?= $pl['nama_pelanggan']; ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <form action="" method="post">

                                            <div class="modal-body">
                                                Apakah anda ingin menghapus pelanggan ini
                                                <input type="hidden" name="idpl" value="<?= $pl['id_pelanggan']; ?>">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success" name="hapuspelanggan">Submit</button> 
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>

                                            </form>

                                            </div>
                                        </div>
                                        </div>
                                        <?php $i ++; ?>
                                        <?php endforeach; ?>
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
        <h4 class="modal-title">Data Tambah Pelanggan</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
<form method="POST">
      <!-- Modal body -->
      <div class="modal-body">
        <input type="text" name="nama_pelanggan" class="form-control mt-3" placeholder="nama pelanggan" >
        <input type="text" name="notelp" class="form-control mt-3" placeholder="no telepon" >
        <input type="num" name="alamat" class="form-control mt-3" placeholder="alamat" >
        <!-- <input type="num" name="stock" class="form-control mt-3" placeholder="stock" > -->
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" name="tambahpelanggan">Simpan</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>

</div>
</form>
</html>
