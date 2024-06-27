<?php 
include './template/header.php';
$produkQuery = mysqli_query($connection, "SELECT * FROM produk");
$totalProduk = mysqli_num_rows($produkQuery); 
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Kelola Barang</h1>
            </div>
            <div class="row">
                <!-- Start of Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Barang</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalProduk; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Card -->
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
                    Data Stock Barang
                </div>
                <div class="card-body">
                    <table class="table table-bordered dataTable" id="datatablesSimple" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                        <thead>
                            <tr role="row">
                                <th style="width: 100px;">No</th>
                                <th style="width: 200px;">Nama Produk</th>
                                <th style="width: 202px;">Deskripsi</th>
                                <th style="width: 201px;">Harga</th>
                                <th style="width: 100px;">Stock</th>
                                <th style="width: 171px;">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Deskripsi</th>
                                <th>Harga</th>
                                <th>Stock</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php 
                            $produkResult = mysqli_query($connection, "SELECT * FROM produk");
                            $i = 1;
                            while ($produk = mysqli_fetch_array($produkResult)) {
                                $idProduk = $produk['id_produk'];
                                $namaProduk = $produk['nama_produk'];
                                $deskripsiProduk = $produk['deskripsi'];
                                $hargaProduk = $produk['harga'];
                                $stockProduk = $produk['stock'];
                            ?> 
                            <tr>
                                <td><?= $idProduk; ?></td>
                                <td><?= $namaProduk; ?></td>
                                <td><?= $deskripsiProduk; ?></td>
                                <td>Rp.<?= number_format($hargaProduk); ?></td>
                                <td><?= $stockProduk; ?></td>
                                <td>
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#edit<?= $idProduk;?>">Edit</button> |
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $idProduk;?>">Delete</button>
                                </td>
                            </tr>

                            <div class="modal fade" id="edit<?= $idProduk; ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Edit Data Produk</h4>
                                        </div>
                                        <form method="POST">
                                            <div class="modal-body">
                                                <input type="hidden" name="id_produk" value="<?= $produk['id_produk'] ?>">
                                                <input type="text" name="nama_produk" class="form-control mt-3" placeholder="Nama Produk" value="<?= $produk['nama_produk'] ?>">
                                                <input type="text" name="deskripsi" class="form-control mt-3" placeholder="Deskripsi Produk" value="<?= $produk['deskripsi'] ?>">
                                                <input type="number" name="harga" class="form-control mt-3" placeholder="Harga" value="<?= $produk['harga'] ?>">
                                                <input type="hidden" name="id_produk" class="form-control mt-3" value="<?= $idProduk; ?>">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success" name="editproduk">Simpan</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Delete -->
                            <div class="modal fade" id="delete<?= $idProduk; ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Hapus Produk</h4>
                                        </div>
                                        <form method="POST">
                                            <div class="modal-body">
                                                Apakah Anda yakin menghapus produk ini?
                                                <input type="hidden" name="id_produk" value="<?= $idProduk; ?>">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success" name="hapusproduk">Hapus</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php 
                            }; // end while
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <!--- Modal --->
    <div class="modal fade" id="myModal">  
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data Produk</h4>
                </div>
                <form method="POST">
                    <!-- Modal body -->
                    <div class="modal-body">
                        <input type="text" name="nama_produk" class="form-control mt-3" placeholder="Nama Produk">
                        <input type="text" name="deskripsi" class="form-control mt-3" placeholder="Deskripsi Produk">
                        <input type="number" name="harga" class="form-control mt-3" placeholder="Harga">
                        <input type="number" name="stock" class="form-control mt-3" placeholder="Stock">
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="tambahproduk">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include './template/footer.php'; ?>
