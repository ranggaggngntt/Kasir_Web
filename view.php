<?php
require 'ceklogin.php';

if(isset($_GET['idp'])){
    $idp = $_GET['idp'];

    $ambilnamapelanggan = mysqli_query($koneksi, 
    "SELECT * FROM pesanan p, pelanggan pl WHERE p.id_pelanggan=pl.id_pelanggan AND p.id_pesanan='$idp'");
    $np = mysqli_fetch_array($ambilnamapelanggan);
    $namapel = $np['nama_pelanggan'];
    $idpel = $np['id_pelanggan'];
}else
{
    header('location:index.php');
}
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
                        <h1 class="mt-4">Data Pesanan : <?= $idp; ?> </h1>
                        <h4 class="mt-4">Nama Pelanggan : <?= $namapel; ?> </h4>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
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
                                            <th>No</th>
                                            <th>Nama Produk</th>
                                            <th>Harga Satuan</th>
                                            <th>Jumlah</th>
                                            <th>Subtotal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $getview = mysqli_query(
                                                $koneksi,
                                                "SELECT * FROM detail_pesanan p, produk pr, pelanggan pl WHERE p.id_produk=pr.id_produk AND id_pesanan='$idp' AND id_pelanggan='$idpel'"
                                            );
                                            $i = 1;
                                            while ($ap = mysqli_fetch_array($getview)) {
                                                $idpr = $ap['id_produk'];
                                                $iddetail = $ap['id_detailpesanan'];
                                                $idp = $ap['id_pesanan'];
                                                $qty = $ap['qty'];
                                                $harga = $ap['harga'];
                                                $nama_produk = $ap['nama_produk'];
                                                $deskripsi = $ap['deskripsi'];
                                                $subtotal = $qty * $harga;
                                        ?>
                                        <tr>
                                            <td><?= $i++; ?></td>                                            
                                            <td><?= $nama_produk; ?> (<?= $deskripsi;?>)</td>
                                            <td>Rp.<?= number_format($harga); ?></td>
                                            <td><?= number_format($qty); ?></td>
                                            <td>Rp.<?= number_format($subtotal); ?></td>
                                            <td><button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#edit<?= $iddetail; ?>">Edit</button> | <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $idpr; ?>">Delete</button></td>
                                        </tr>
                                        <?php 
                                            }; // end while
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
</html>

<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Tambah Pesanan</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <!-- Modal body -->
                <div class="modal-body">
                    Pilih Barang
                    <select name="id_produk" class="form-control">
                        <?php
                            $getproduk = mysqli_query($koneksi, "SELECT * FROM produk");
                            while ($pl = mysqli_fetch_array($getproduk)) {
                                $idproduk = $pl['id_produk'];
                                $namaproduk = $pl['nama_produk'];
                                $deskripsi = $pl['deskripsi'];
                                $stock = $pl['stock'];
                        ?>
                        <option value="<?= $idproduk; ?>"><?= $namaproduk; ?> - <?= $deskripsi; ?> (Stock: <?= $stock; ?>)</option>
                        <?php
                            }
                        ?>
                    </select>
                    <input type="number" name="qty" class="form-control mt-2" placeholder="Jumlah">
                    <input type="hidden" name="idp" value="<?= $idp; ?>">
                    <input type="hidden" name="idpel" value="<?= $idpel; ?>">
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="addproduk">Submit</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php
// Loop again to generate modals
$getview = mysqli_query(
    $koneksi,
    "SELECT * FROM detail_pesanan p, produk pr, pelanggan pl WHERE p.id_produk=pr.id_produk AND id_pesanan='$idp' AND id_pelanggan='$idpel'"
);
while ($ap = mysqli_fetch_array($getview)) {
    $idpr = $ap['id_produk'];
    $iddetail = $ap['id_detailpesanan'];
    $idp = $ap['id_pesanan'];
    $qty = $ap['qty'];
?>
    <div class="modal" id="delete<?= $idpr; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Hapus Pesanan</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        Apakah Anda yakin menghapus barang ini?
                        <input type="hidden" name="idp" value="<?= $idp; ?>">
                        <input type="hidden" name="idpr" value="<?= $idpr; ?>">
                        <input type="hidden" name="iddetail" value="<?= $iddetail; ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="hapusprodukpesanan">Hapus</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- Modal Edit -->
    <div class="modal" id="edit<?= $iddetail; ?>">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Data Pesanan</h4>
                    <button type="button" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <!-- Modal body -->
                    <div class="modal-body">
                        <input type="hidden" name="idp" value="<?= $idp; ?>">
                        <input type="hidden" name="idpr" value="<?= $idpr; ?>">
                        <input type="hidden" name="iddetail" value="<?= $iddetail; ?>">
                        <input type="number" name="qty" class="form-control mt-3"
                            placeholder="quantity" min="1" required
                            value="<?= $qty; ?>">
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"
                            name="editdetailpesanan">Edit</button>
                        <button type="button" class="btn btn-danger"
                            data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
} // end while
?>
