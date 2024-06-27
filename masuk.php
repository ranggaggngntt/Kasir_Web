<?php
require 'ceklogin.php';
$barang = mysqli_query($koneksi, "SELECT * FROM masuk m, produk p WHERE m.id_produk=p.id_produk");

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
                                Stock Barang masuk
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
                        <h1 class="mt-4">Stock Barang Masuk</h1>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                 
                                <div >
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                    Tambah Barang Masuk
                                </button>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3 mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Data Stock Barang Masuk
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Produk</th>
                                            <th>Deskripsi</th>
                                            <th>Jumlah</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($barang as $brg) : ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= $brg['nama_produk'] ?></td>
                                            <td><?= $brg['deskripsi'] ?></td>
                                            <td><?= $brg['qty'] ?></td>
                                            <td><?= $brg['tgl_masuk'] ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $brg['id_masuk'];?>">Edit</button>
                                                |
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $brg['id_masuk'];?>">Delete</button>
                                            </td>
                                        </tr>
                                        <!-- Modal Edit--> 
                                        <div class="modal fade" id="edit<?= $brg['id_masuk'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Ubah Data Barang Masuk</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <form action="" method="post">

                                            <div class="modal-body">
                                            <input type="text" name="namaproduk" class="form-control" placeholder="Nama Produk" value="<?= $brg['nama_produk']; ?>" disabled>
                                                    <input type="number" name="qty" class="form-control mt-2" placeholder="jumlah" value="<?= $brg['qty']; ?>" min="1" required>
                                                    <input type="hidden" name="idm" value="<?= $brg['id_masuk']; ?>">
                                                    <input type="hidden" name="idp" value="<?= $brg['id_produk']; ?>">
                                            </div>
                                            <div class="modal-footer">
                                            <button type="submit" class="btn btn-success" name="editmasuk">Submit</button> 
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>

                                            </form>

                                            </div>
                                        </div>
                                        </div>

                                        <!-- Modal Delete-->
                                        <div class="modal fade" id="delete<?= $brg['id_masuk'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Hapus Data Barang Masuk</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <form action="" method="post">

                                            <div class="modal-body">
                                                Apakah anda ingin menghapus data ini
                                                <input type="hidden" name="idp" value="<?= $brg['id_produk']; ?>">
                                                <input type="hidden" name="idm" value="<?= $brg['id_masuk']; ?>">
                                            </div>
                                            <div class="modal-footer">
                                            <button type="submit" class="btn btn-success" name="hapusdatabarangmasuk">Submit</button> 
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
                            <div class="text-muted">Copyright &copy; Zaidan 2024</div>
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
                    <h4 class="modal-title">Data Barang Masuk</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        Pilih Barang
                        <select name="id_produk" id="" class="form-control">
                        <?php 
                            $getproduk = mysqli_query($koneksi, "SELECT * FROM produk");      
                                while($pl = mysqli_fetch_array($getproduk)){
                                    $idproduk = $pl['id_produk'];
                                    $namaproduk = $pl['nama_produk'];
                                    $stock = $pl['stock'];
                                    $deskripsi = $pl['deskripsi'];
                        ?> 
                            <option value="<?= $idproduk; ?>"><?= $namaproduk; ?> - <?= $deskripsi; ?> (Stock : <?= $stock; ?>) </option>
                        <?php 
                            };
                        ?>
                        </select>
                        <input type="number" name="qty" class="form-control mt-4" placeholder="Jumlah" min="1" required>
                    </div>
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="barangmasuk">Submit</button> 
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                    </form>
            </div>
        </div>
    </div>
</html>
