<?php 
include './template/header.php';
$h1 = mysqli_query($connection, "SELECT * FROM pesanan");
$h2 = mysqli_num_rows($h1);
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            </div>
            <div class="row">
                <!-- Start of Card Pesanan -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Pesanan</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $h2; ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Card Pesanan -->
            </div>
            <div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
                    Tambah Pesanan
                </button>
            </div>
            <div class="card mt-3 mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Data Pesanan
                </div>
                <div class="card-body">
                    <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                        <thead>
                            <tr role="row">
                                <th style="width: 100px;">ID Pesanan</th>
                                <th style="width: 200px;">Tanggal Pesan</th>
                                <th style="width: 202px;">Nama Pelanggan</th>
                                <th style="width: 201px;">Alamat</th>
                                <th style="width: 100px;">Jumlah</th>
                                <th style="width: 171px;">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Tanggal Pesan</th>
                                <th>Nama Pelanggan</th>
                                <th>Alamat</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            $getpesanan = mysqli_query($connection, "SELECT * FROM pesanan p, pelanggan pl WHERE p.id_pelanggan=pl.id_pelanggan");
                            $counter = 1;
                            while ($p = mysqli_fetch_array($getpesanan)) {
                                $id_pesanan = $p["id_pesanan"];
                                $tanggal = $p["tgl_pesan"];
                                $nama_pelanggan = $p["nama_pelanggan"];
                                $alamat = $p["alamat"];
                                $hitungjumlah = mysqli_query($connection, "SELECT * FROM detail_pesanan WHERE id_pesanan='$id_pesanan'");
                                $jumlah = mysqli_num_rows($hitungjumlah);
                                $rowClass = $counter % 2 == 0 ? "even" : "odd";
                            ?>
                                <tr class="<?php echo $rowClass; ?>">
                                    <td class="sorting_1"><?= $id_pesanan ?></td>
                                    <td><?= $tanggal ?></td>
                                    <td><?= $nama_pelanggan ?></td>
                                    <td><?= $alamat ?></td>
                                    <td><?= $jumlah ?></td>
                                    <td>
                                        <a href="view.php?idp=<?= $id_pesanan ?>" class="btn btn-primary">Tampilkan</a> |
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $id_pesanan ?>">Delete</button>
                                    </td>
                                </tr>
                                <div class="modal fade" id="delete<?= $id_pesanan; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $id_pesanan; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Hapus Barang</h4>
                                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="POST">
                                                <div class="modal-body">
                                                    Apakah Anda yakin menghapus barang ini?
                                                    <input type="hidden" name="idp" value="<?= $id_pesanan; ?>">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success" name="hapuspesanan">Hapus</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php $counter++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <div class="modal fade" id="modalTambah">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Data Tambah Pesanan</h4>
                </div>
                <form method="POST">
                    <!-- Modal body -->
                    <div class="modal-body">
                        Pilih Pelanggan
                        <select name="id_pelanggan" class="form-control">
                            <?php
                            $getpelanggan = mysqli_query($connection, "SELECT * FROM pelanggan");
                            while ($pl = mysqli_fetch_array($getpelanggan)) {
                                $id_pelanggan = $pl["id_pelanggan"];
                                $nama_pelanggan = $pl["nama_pelanggan"];
                                $alamat = $pl["alamat"];
                            ?>
                                <option value="<?= $id_pelanggan ?>"><?= $nama_pelanggan ?> - <?= $alamat ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="tambahpesanan">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include './template/footer.php'; ?>