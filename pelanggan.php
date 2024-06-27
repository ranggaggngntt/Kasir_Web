<?php 
include './template/header.php';
$dataPelanggan = mysqli_query($connection, "SELECT * FROM pelanggan");
$jumlahPelanggan = mysqli_num_rows($dataPelanggan);
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Kelola Pelanggan</h1>
            </div>
            <div class="row">
                <!-- Start of Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Pelanggan</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlahPelanggan; ?></div>
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
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahPelanggan">
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
                    <table class="table table-bordered dataTable" id="datatablesSimple" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                        <thead>
                            <tr role="row">
                                <th style="width: 100px;">No</th>
                                <th style="width: 200px;">Nama Pelanggan</th>
                                <th style="width: 102px;">No Telpon</th>
                                <th style="width: 251px;">Alamat</th>
                                <th style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>No Telpon</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php $nomor = 1; ?>
                            <?php foreach ($dataPelanggan as $pelanggan) : ?>
                            <tr>
                                <td><?= $nomor; ?></td>
                                <td><?= $pelanggan['nama_pelanggan']; ?></td>
                                <td><?= $pelanggan['notelp']; ?></td>
                                <td><?= $pelanggan['alamat']; ?></td>
                                <td>
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#edit<?= $pelanggan['id_pelanggan'];?>">Edit</button> |
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $pelanggan['id_pelanggan'];?>">Delete</button>
                                </td>
                            </tr>
                            <!-- Modal Edit--> 
                            <div class="modal fade" id="edit<?= $pelanggan['id_pelanggan'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Ubah <?= $pelanggan['nama_pelanggan']; ?></h5>
                                        </div>
                                        <form action="" method="post">
                                            <div class="modal-body">
                                                <input type="text" name="nama_pelanggan" class="form-control" placeholder="Nama Pelanggan" value="<?= $pelanggan['nama_pelanggan']; ?>">
                                                <input type="text" name="notelp" class="form-control mt-2" placeholder="No. Telp" value="<?= $pelanggan['notelp']; ?>">
                                                <input type="text" name="alamat" class="form-control mt-2" placeholder="Alamat" value="<?= $pelanggan['alamat']; ?>">
                                                <input type="hidden" name="id_pelanggan" value="<?= $pelanggan['id_pelanggan']; ?>">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success" name="editpelanggan">Submit</button> 
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Delete-->
                            <div class="modal fade" id="delete<?= $pelanggan['id_pelanggan'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Hapus <?= $pelanggan['nama_pelanggan']; ?></h5>
                                        </div>
                                        <form action="" method="post">
                                            <div class="modal-body">
                                                Apakah anda ingin menghapus pelanggan ini?
                                                <input type="hidden" name="id_pelanggan" value="<?= $pelanggan['id_pelanggan']; ?>">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success" name="hapuspelanggan">Submit</button> 
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php $nomor++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <div class="modal fade" id="modalTambahPelanggan">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Data Tambah Pelanggan</h4>
                </div>
                <form method="POST">
                    <!-- Modal body -->
                    <div class="modal-body">
                        <input type="text" name="nama_pelanggan" class="form-control mt-3" placeholder="Nama Pelanggan">
                        <input type="text" name="notelp" class="form-control mt-3" placeholder="No Telepon">
                        <input type="text" name="alamat" class="form-control mt-3" placeholder="Alamat">
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="tambahpelanggan">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php include './template/footer.php'; ?>
