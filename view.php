<?php 
include './template/header.php';

if (isset($_GET['id_pesanan'])) {
    $id_pesanan = $_GET['id_pesanan'];

    $query_pelanggan = mysqli_query($connection, 
        "SELECT * FROM pesanan p, pelanggan pl WHERE p.id_pelanggan=pl.id_pelanggan AND p.id_pesanan='$id_pesanan'");
    $data_pelanggan = mysqli_fetch_array($query_pelanggan);
    $nama_pelanggan = $data_pelanggan['nama_pelanggan'];
    $id_pelanggan = $data_pelanggan['id_pelanggan'];
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
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $id_pesanan; ?></div>
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
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $nama_pelanggan; ?></div>
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
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahPesanan">
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
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Harga Satuan</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            $query_detail_pesanan = mysqli_query(
                                $connection,
                                "SELECT * FROM detail_pesanan dp, produk pr, pelanggan pl WHERE dp.id_produk=pr.id_produk AND id_pesanan='$id_pesanan' AND id_pelanggan='$id_pelanggan'"
                            );
                            $no = 1;
                            while ($data_pesanan = mysqli_fetch_array($query_detail_pesanan)) {
                                $id_produk = $data_pesanan['id_produk'];
                                $id_detail_pesanan = $data_pesanan['id_detailpesanan'];
                                $jumlah = $data_pesanan['qty'];
                                $harga_satuan = $data_pesanan['harga'];
                                $nama_produk = $data_pesanan['nama_produk'];
                                $deskripsi_produk = $data_pesanan['deskripsi'];
                                $subtotal = $jumlah * $harga_satuan;
                            ?>
                            <tr>
                                <td class="sorting_1"><?= $no++; ?></td>
                                <td><?= $nama_produk; ?> (<?= $deskripsi_produk; ?>)</td>
                                <td>Rp.<?= number_format($harga_satuan); ?></td>
                                <td><?= number_format($jumlah); ?></td>
                                <td>Rp.<?= number_format($subtotal); ?></td>
                                <td>
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalEdit<?= $id_detail_pesanan; ?>">Edit</button> | 
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalHapus<?= $id_produk; ?>">Delete</button>
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
    
    <!-- Modal Tambah Pesanan -->
    <div class="modal fade" id="modalTambahPesanan">
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
                            $query_produk = mysqli_query($connection, "SELECT * FROM produk");
                            while ($data_produk = mysqli_fetch_array($query_produk)) {
                                $id_produk = $data_produk['id_produk'];
                                $nama_produk = $data_produk['nama_produk'];
                                $deskripsi_produk = $data_produk['deskripsi'];
                                $stok_produk = $data_produk['stock'];
                            ?>
                            <option value="<?= $id_produk; ?>"><?= $nama_produk; ?> - <?= $deskripsi_produk; ?> (Stock: <?= $stok_produk; ?>)</option>
                            <?php
                            }
                            ?>
                        </select>
                        <input type="number" name="jumlah" class="form-control mt-2" placeholder="Jumlah">
                        <input type="hidden" name="id_pesanan" value="<?= $id_pesanan; ?>">
                        <input type="hidden" name="id_pelanggan" value="<?= $id_pelanggan; ?>">
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="tambah_produk">Submit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    // Loop again to generate modals
    $query_detail_pesanan = mysqli_query(
        $connection,
        "SELECT * FROM detail_pesanan dp, produk pr, pelanggan pl WHERE dp.id_produk=pr.id_produk AND id_pesanan='$id_pesanan' AND id_pelanggan='$id_pelanggan'"
    );
    while ($data_pesanan = mysqli_fetch_array($query_detail_pesanan)) {
        $id_produk = $data_pesanan['id_produk'];
        $id_detail_pesanan = $data_pesanan['id_detailpesanan'];
        $jumlah = $data_pesanan['qty'];
    ?>
    <!-- Modal Hapus -->
    <div class="modal fade" id="modalHapus<?= $id_produk; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Hapus Pesanan</h4>
                    
                </div>
                <form method="POST">
                    <div class="modal-body">
                        Apakah Anda yakin menghapus pesanan ini?
                        <input type="hidden" name="id_pesanan" value="<?= $id_pesanan; ?>">
                        <input type="hidden" name="id_produk" value="<?= $id_produk; ?>">
                        <input type="hidden" name="id_detail_pesanan" value="<?= $id_detail_pesanan; ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="hapus_produk_pesanan">Hapus</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit<?= $id_detail_pesanan; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Data Pesanan</h4>
                    
                </div>
                <form method="POST">
                    <!-- Modal body -->
                    <div class="modal-body">
                        <input type="hidden" name="id_pesanan" value="<?= $id_pesanan; ?>">
                        <input type="hidden" name="id_produk" value="<?= $id_produk; ?>">
                        <input type="hidden" name="id_detail_pesanan" value="<?= $id_detail_pesanan; ?>">
                        <input type="number" name="jumlah" class="form-control mt-3" placeholder="quantity" min="1" required value="<?= $jumlah; ?>">
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="edit_detail_pesanan">Edit</button>
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
