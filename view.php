<?php 
include './template/header.php';

if (isset($_GET['idp'])) {
    $idp = $_GET['idp'];

    $ambilnamapelanggan = mysqli_query($connection, 
        "SELECT * FROM pesanan p, pelanggan pl WHERE p.id_pelanggan=pl.id_pelanggan AND p.id_pesanan='$idp'");
    $np = mysqli_fetch_array($ambilnamapelanggan);
    $namapel = $np['nama_pelanggan'];
    $idpel = $np['id_pelanggan'];
} else {
    header('location:index.php');
}
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <div class="row">
                <!-- Start of Card Pesanan -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Data Pesanan</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $idp; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Card Pesanan -->
                <!-- Start of Card Nama Pelanggan -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Nama Pelanggan</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $namapel; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Card Nama Pelanggan -->
            </div>
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
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
                    <table class="table table-bordered dataTable" id="datatablesSimple" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                        <thead>
                            <tr role="row">
                                <th style="width: 100px;">No</th>
                                <th style="width: 200px;">Nama Produk</th>
                                <th style="width: 202px;">Harga Satuan</th>
                                <th style="width: 201px;">Jumlah</th>
                                <th style="width: 100px;">Subtotal</th>
                                <th style="width: 171px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $getview = mysqli_query(
                                $connection,
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
                                <td class="sorting_1"><?= $i++; ?></td>
                                <td><?= $nama_produk; ?> (<?= $deskripsi; ?>)</td>
                                <td>Rp.<?= number_format($harga); ?></td>
                                <td><?= number_format($qty); ?></td>
                                <td>Rp.<?= number_format($subtotal); ?></td>
                                <td>
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#edit<?= $iddetail; ?>">Edit</button> | 
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $idpr; ?>">Delete</button>
                                </td>
                            </tr>
                            <?php 
                            } // end while
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    
    <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Pesanan</h4>
                    
                </div>
                <form method="POST">
                    <!-- Modal body -->
                    <div class="modal-body">
                        Pilih Barang
                        <select name="id_produk" class="form-control">
                            <?php
                            $getproduk = mysqli_query($connection, "SELECT * FROM produk");
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
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    // Loop again to generate modals
    $getview = mysqli_query(
        $connection,
        "SELECT * FROM detail_pesanan p, produk pr, pelanggan pl WHERE p.id_produk=pr.id_produk AND id_pesanan='$idp' AND id_pelanggan='$idpel'"
    );
    while ($ap = mysqli_fetch_array($getview)) {
        $idpr = $ap['id_produk'];
        $iddetail = $ap['id_detailpesanan'];
        $idp = $ap['id_pesanan'];
        $qty = $ap['qty'];
    ?>
    <!-- Modal Delete -->
    <div class="modal fade" id="delete<?= $idpr; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Hapus Pesanan</h4>
                    
                </div>
                <form method="POST">
                    <div class="modal-body">
                        Apakah Anda yakin menghapus pesanan ini?
                        <input type="hidden" name="idp" value="<?= $idp; ?>">
                        <input type="hidden" name="idpr" value="<?= $idpr; ?>">
                        <input type="hidden" name="iddetail" value="<?= $iddetail; ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="hapusprodukpesanan">Hapus</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Edit -->
    <div class="modal fade" id="edit<?= $iddetail; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Data Pesanan</h4>
                    
                </div>
                <form method="POST">
                    <!-- Modal body -->
                    <div class="modal-body">
                        <input type="hidden" name="idp" value="<?= $idp; ?>">
                        <input type="hidden" name="idpr" value="<?= $idpr; ?>">
                        <input type="hidden" name="iddetail" value="<?= $iddetail; ?>">
                        <input type="number" name="qty" class="form-control mt-3" placeholder="quantity" min="1" required value="<?= $qty; ?>">
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="editdetailpesanan">Edit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    } // end while
    ?>

    <?php include './template/footer.php'; ?>
</div>


