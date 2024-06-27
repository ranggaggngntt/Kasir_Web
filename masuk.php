<?php 
include './template/header.php';
$queryBarangMasuk = mysqli_query($connection, "SELECT * FROM masuk m, produk p WHERE m.id_produk=p.id_produk");
$totalBarangMasuk = mysqli_num_rows($queryBarangMasuk);
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Stock Barang Masuk</h1>
            </div>
            <div class="row">
                <!-- Start of Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Barang Masuk</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalBarangMasuk; ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
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
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahBarangMasuk">
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
                    <table class="table table-bordered dataTable" id="datatablesSimple" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                        <thead>
                            <tr role="row">
                                <th style="width: 100px;">No</th>
                                <th style="width: 200px;">Nama Produk</th>
                                <th style="width: 202px;">Deskripsi</th>
                                <th style="width: 101px;">Jumlah</th>
                                <th style="width: 200px;">Tanggal</th>
                                <th style="width: 171px;">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Deskripsi</th>
                                <th>Jumlah</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($queryBarangMasuk as $barang) : ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= $barang['nama_produk'] ?></td>
                                <td><?= $barang['deskripsi'] ?></td>
                                <td><?= $barang['qty'] ?></td>
                                <td><?= $barang['tgl_masuk'] ?></td>
                                <td>
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalEdit<?= $barang['id_masuk'];?>">Edit</button>
                                    |
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalDelete<?= $barang['id_masuk'];?>">Delete</button>
                                </td>
                            </tr>
                            <!-- Modal Edit--> 
                            <div class="modal fade" id="modalEdit<?= $barang['id_masuk'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Ubah Data Barang Masuk</h5>
                                        </div>
                                        <form action="" method="post">
                                            <div class="modal-body">
                                                <input type="text" name="nama_produk" class="form-control" placeholder="Nama Produk" value="<?= $barang['nama_produk']; ?>" disabled>
                                                <input type="number" name="qty" class="form-control mt-2" placeholder="Jumlah" value="<?= $barang['qty']; ?>" min="1" required>
                                                <input type="hidden" name="id_masuk" value="<?= $barang['id_masuk']; ?>">
                                                <input type="hidden" name="id_produk" value="<?= $barang['id_produk']; ?>">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success" name="editmasuk">Submit</button> 
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Delete-->
                            <div class="modal fade" id="modalDelete<?= $barang['id_masuk'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Hapus Data Barang Masuk</h5>
                                        </div>
                                        <form action="" method="post">
                                            <div class="modal-body">
                                                Apakah anda ingin menghapus data ini?
                                                <input type="hidden" name="id_produk" value="<?= $barang['id_produk']; ?>">
                                                <input type="hidden" name="id_masuk" value="<?= $barang['id_masuk']; ?>">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success" name="hapusdatabarangmasuk">Submit</button> 
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php $no++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <div class="modal fade" id="modalTambahBarangMasuk">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Data Barang Masuk</h4>
                </div>
                <form method="post">
                    <div class="modal-body">
                        Pilih Barang
                        <select name="id_produk" class="form-control">
                        <?php 
                            $queryProduk = mysqli_query($connection, "SELECT * FROM produk");      
                            while($produk = mysqli_fetch_array($queryProduk)){
                                $idProduk = $produk['id_produk'];
                                $namaProduk = $produk['nama_produk'];
                                $stokProduk = $produk['stock'];
                                $deskripsiProduk = $produk['deskripsi'];
                        ?> 
                            <option value="<?= $idProduk; ?>"><?= $namaProduk; ?> - <?= $deskripsiProduk; ?> (Stock : <?= $stokProduk; ?>) </option>
                        <?php 
                            };
                        ?>
                        </select>
                        <input type="number" name="qty" class="form-control mt-4" placeholder="Jumlah" min="1" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="barangmasuk">Submit</button> 
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include './template/footer.php'; ?>
