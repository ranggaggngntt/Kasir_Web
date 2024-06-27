<?php
session_start();

$koneksi = mysqli_connect('localhost','root','','kasir');

if(isset($_POST['login'])){
    //initial variable
    $username = $_POST['username'];
    $password = $_POST['password'];

    $check = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' AND password='$password' ");
    $hitung = mysqli_num_rows($check);
    
    if($hitung>0){
        //jika datanya ada, dan ditemukan
        //berhasil login
        $_SESSION['login'] = true;
        header('location:index.php');
    } else{
        //datanya g ada
        //gagal login
        echo '
        <script>
        alert("Username atau Password salah")
        window.location.href="login.php"
        </script>';
    }
}

if (isset($_POST['tambahproduk'])){
    //deskripsi initial variable
    $nama_produk = $_POST['nama_produk'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stock = $_POST['stock'];

    $insert_produk = mysqli_query($koneksi, "INSERT INTO produk (nama_produk, deskripsi, harga, stock)
    VALUES ('$nama_produk','$deskripsi','$harga','$stock')");

    if ($insert_produk) {
        header('location:stock.php');
    } else{
        echo '
        <script>
        alert("Gagal tambah produk")
        window.location.href="stock.php"
        </script>';
    }

}

if (isset($_POST['tambahpelanggan'])){
    //deskripsi initial variable
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];

    $insert_pelanggan = mysqli_query($koneksi, "INSERT INTO pelanggan (nama_pelanggan, notelp, alamat)
    VALUES ('$nama_pelanggan','$notelp','$alamat')");

    if ($insert_pelanggan) {
        header('location:pelanggan.php');
    } else{
        echo '
        <script>
        alert("Gagal tambah pelanggan")
        window.location.href="pelanggan.php"
        </script>';
    }
}

if (isset($_POST['tambahpesanan'])){
    //deskripsi initial variable
    $id_pelanggan = $_POST['id_pelanggan'];

    $insert_pesanan = mysqli_query($koneksi, "INSERT INTO pesanan (id_pelanggan) 
    VALUES ('$id_pelanggan')");

    if ($insert_pesanan) {
        header('location:index.php');
    } else{
        echo '
        <script>
        alert("Gagal tambah pesanan")
        window.location.href="index.php"
        </script>';
    }

}

if (isset($_POST['addproduk'])){
    var_dump($_POST);
    //deskripsi initial variable
    $id_produk = $_POST['id_produk'];
    $idp = $_POST['idp'];
    $qty = $_POST['qty'];

    //hitung stock sekarang ada berapa
    $hitung1 = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$id_produk'");
    $hitung2 = mysqli_fetch_array($hitung1);
    $stocksekarang = $hitung2['stock']; //stock barang saat ini

    if($stocksekarang>=$qty){
        //kurangin stocknya dengan jumlah yang akan dikeluarkan
        $selisih = $stocksekarang - $qty;


        //stocknya cukup
        $insert = mysqli_query($koneksi, "INSERT INTO detail_pesanan (id_pesanan, id_produk, qty) 
        VALUES ('$idp','$id_produk','$qty')"); 
        $update = mysqli_query($koneksi, "UPDATE produk SET stock='$selisih' WHERE id_produk='$id_produk'");

        if ($insert && $update) {
             header('location:view.php?idp='.$idp);
        } else{
             echo '
             <script>
                alert("Gagal tambah produk")
                window.location.href="view.php"'.$idp.'
            </script>';
                }
    }else
    //stock tidak cukup
            echo '
             <script>
                alert("Stock tidak cukup")
                window.location.href="view.php"'.$idp.'
            </script>';

}

//hapus produk pesanan
if(isset($_POST['hapusprodukpesanan'])){
    $iddetail = $_POST['iddetail']; //detail pesanan
    $idpr = $_POST['idpr'];
    $idp = $_POST['idp'];

    //cek qty sekarang
    $cek1 = mysqli_query($koneksi, 
    "SELECT * FROM detail_pesanan WHERE id_detailpesanan='$iddetail'") ;
    $cek2 = mysqli_fetch_array($cek1);
    $qtysekarang = $cek2['qty'];

    //cek stok sekarang
    $cek3 = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$idpr'");
    $cek4 = mysqli_fetch_array($cek3);
    $cekstocksekarang = $cek4['stock'];

    $hitung = $cekstocksekarang+$qtysekarang;

    $update = mysqli_query($koneksi,"UPDATE produk SET stock='$hitung' WHERE id_produk='$idpr'"); // untuk update stock
    $hapus = mysqli_query($koneksi, "DELETE FROM detail_pesanan WHERE id_produk='$idpr' AND id_detailpesanan='$iddetail'");

    if($update&&$hapus){
        header('location:view.php?idp='.$idp);
    }else{
        echo '
        <script>
        alert("Stock tidak cukup")
        window.location.href="view.php"'.$idp.'
        </script>';

    }

}

//edit barang
if(isset($_POST['editproduk'])){
    $np = $_POST['nama_produk'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $idpr = $_POST['id_produk']; 

    $edit_barang = mysqli_query($koneksi, 
    "UPDATE produk SET nama_produk='$np', deskripsi='$deskripsi', harga='$harga' WHERE id_produk='$idpr'");

    if ($edit_barang){
        header('location:stock.php');
    }else{
        echo '
        <script>
        alert("Gagal Edit")
        window.location.href="stock.php"
        </script>';
    }
}

if (isset($_POST['editdetailpesanan'])) {
    $qty = $_POST['qty'];
    $iddp = $_POST['iddetail']; //id masuk
    $idpr = $_POST['idpr']; // idproduk
    $idp = $_POST['idp']; //id pesanan

    //cari qty sekarang
    $caritahu = mysqli_query($koneksi, "SELECT * FROM detail_pesanan WHERE id_detailpesanan='$iddp'");
    $caritahu2 = mysqli_fetch_array($caritahu);
    $qtysekarang = $caritahu2['qty'];

    //cari tahu stock sekarang
    $caristock = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$idpr'");
    $caristock2 = mysqli_fetch_array($caristock);
    $stocksekarang = $caristock2['stock'];

    if ($qty >= $qtysekarang) {
        $selisih = $qty - $qtysekarang;
        $newstock= $stocksekarang - $selisih;

        $query1 = mysqli_query($koneksi,"UPDATE detail_pesanan set qty='$qty' where id_detailpesanan='$iddp'");
        $query2 = mysqli_query($koneksi,"UPDATE produk set stock='$newstock' where id_produk='$idpr'");

        if ($query1&&$query2) {
            header('location: view.php?idp='.$idp);
        }else{
            echo "
                <script>
                    alert('Gagal Edit barang!');
                    window.location.href='view.php?idp=$idp';
                </script>
            ";
        }

    }else{
        //hitung selisih
        $selisih = $qtysekarang - $qty;
        $newstock= $stocksekarang + $selisih;

        $query1 = mysqli_query($koneksi,"UPDATE detail_pesanan set qty='$qty' where id_detailpesanan='$iddp'");
        $query2 = mysqli_query($koneksi,"UPDATE produk set stock='$newstock' where id_produk='$idpr'");

        if ($query1&&$query2) {
            header('location: view.php?idp='.$idp);
        }else{
            echo "
                <script>
                    alert('Gagal Edit barang!');
                    window.location.href='view.php?idp=$idp';
                </script>
            ";
        }
    }
}

if (isset($_POST['hapusproduk'])) {
    $idp = $_POST['idp'];

    $query = mysqli_query($koneksi,"DELETE FROM produk where id_produk='$idp'");

    if ($query) {
        header('location: stock.php');
    }else{
        echo "
            <script>
                alert('Gagal Edit barang!');
                window.location.href='view.php?idp=$idorder'
            </script>
        ";
    }
}

if (isset($_POST['hapuspesanan'])) {
    $idp = $_POST['idp'];

    $cekdata = mysqli_query($koneksi, "SELECT * FROM detail_pesanan WHERE id_pesanan='$idp'");

    while ($ok=mysqli_fetch_array($cekdata)) { 
        //balikin stok
        $qty=$ok['qty'];
        $idproduk=$ok['id_produk'];
        $iddp=$ok['id_detailpesanan'];

        //cari tahu stock sekarang
        $caristock = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$idproduk'");
        $caristock2 = mysqli_fetch_array($caristock);
        $stocksekarang = $caristock2['stock'];

        $newstock = $stocksekarang+$qty;

        $queryupdate=mysqli_query($koneksi,"UPDATE produk set stock='$newstock' where id_produk='$idproduk'");
        
        //hapus data
        $querydelete = mysqli_query($koneksi,"DELETE FROM detail_pesanan where id_detailpesanan='$iddp'");
        
    }

    $query = mysqli_query($koneksi,"DELETE FROM pesanan where id_pesanan='$idp'");

    if ($queryupdate&&$querydelete&&$query) {
        header('location: index.php');
    }else if($query){
        echo "
            <script>
                alert('Berhasil Hapus!');
                window.location.href='index.php'
            </script>
        ";
    }else{
        echo "
            <script>
                alert('Gagal Hapus pelanggan!');
                window.location.href='index.php'
            </script>
        ";
    }
}

//tambah barang masuk
if (isset($_POST['barangmasuk'])) {

    $idproduk = $_POST['id_produk'];
    $qty = $_POST['qty'];

    //cari tahu stock sekarang
    $caristock = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$idproduk'");
    $caristock2 = mysqli_fetch_array($caristock);
    $stocksekarang = $caristock2['stock'];

    //hitung stock
    $newstockb = $stocksekarang+$qty;

        $insertb = mysqli_query($koneksi, "INSERT INTO masuk (id_produk, qty)VALUES ('$idproduk', '$qty')");
        $updateb = mysqli_query($koneksi, "UPDATE produk SET stock='$newstockb' where id_produk='$idproduk'");

        if ($insertb&&$updateb) {
            
            header('location: masuk.php');

        }else{
            echo "
            <script>
                alert('Gagal!');
                window.location.href='masuk.php';
            </script>
        ";
        }
        
}

if (isset($_POST['editmasuk'])) {
    $qty = $_POST['qty'];
    $idm = $_POST['idm'];
    $idp = $_POST['idp'];

    //cari qty sekarang
    $caritahu = mysqli_query($koneksi, "SELECT * FROM masuk WHERE id_masuk='$idm'");
    $caritahu2 = mysqli_fetch_array($caritahu);
    $qtysekarang = $caritahu2['qty'];

    //cari tahu stock sekarang
    $caristock = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$idp'");
    $caristock2 = mysqli_fetch_array($caristock);
    $stocksekarang = $caristock2['stock'];

    if ($qty >= $qtysekarang) {
        $selisih = $qty - $qtysekarang;
        $newstock= $stocksekarang + $selisih;

        $query1 = mysqli_query($koneksi,"UPDATE masuk set qty='$qty' where id_masuk='$idm'");
        $query2 = mysqli_query($koneksi,"UPDATE produk set stock='$newstock' where id_produk='$idp'");

        if ($query1&&$query2) {
            header('location: masuk.php');
        }else{
            echo "
                <script>
                    alert('Gagal Edit barang!');
                    window.location.href='masuk.php'
                </script>
            ";
        }

    }else{
        //hitung selisih
        $selisih = $qtysekarang - $qty;
        $newstock= $stocksekarang - $selisih;

        $query1 = mysqli_query($koneksi,"UPDATE masuk set qty='$qty' where id_masuk='$idm'");
        $query2 = mysqli_query($koneksi,"UPDATE produk set stock='$newstock' where id_produk='$idp'");

        if ($query1&&$query2) {
            header('location: masuk.php');
        }else{
            echo "
                <script>
                    alert('Gagal Edit barang!');
                    window.location.href='masuk.php'
                </script>
            ";
        }
    }
}

//hapus data barang masuk
if (isset($_POST['hapusdatabarangmasuk'])) {
    $idm = $_POST['idm'];
    $idp = $_POST['idp'];
    
    //cari qty sekarang
    $caritahu = mysqli_query($koneksi, "SELECT * FROM masuk WHERE id_masuk='$idm'");
    $caritahu2 = mysqli_fetch_array($caritahu);
    $qtysekarang = $caritahu2['qty'];

    //cari tahu stock sekarang
    $caristock = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$idp'");
    $caristock2 = mysqli_fetch_array($caristock);
    $stocksekarang = $caristock2['stock'];

    //hitung stock baru
    $newstock = $stocksekarang - $qtysekarang;
    echo "<script>alert('". $stocksekarang ."');</script>";
    $query1 = mysqli_query($koneksi,"DELETE FROM masuk WHERE id_masuk='$idm'");
    $query2 = mysqli_query($koneksi,"UPDATE produk set stock='$newstock' WHERE id_produk='$idp'");

    if ($query1 && $query2) {
        header('location: masuk.php');
    } else {
        echo "
            <script>
                alert('Gagal Edit barang!');
                window.location.href='masuk.php'
            </script>
        ";
    }
}

//edit pelanggan
if (isset($_POST['editpelanggan'])) {
    $np = $_POST['nama_pelanggan'];
    $not = $_POST['notelp'];
    $alamat = $_POST['alamat'];
    $idpl = $_POST['idpl'];

    $query = mysqli_query($koneksi,"UPDATE pelanggan set nama_pelanggan='$np', notelp='$not', alamat='$alamat' where id_pelanggan='$idpl'");

    if ($query) {
        header('location: pelanggan.php');
    }else{
        echo "
            <script>
                alert('Gagal Edit pelanggan!');
                window.location.href='pelanggan.php'
            </script>
        ";
    }
}

//hapus pelanggan
if (isset($_POST['hapuspelanggan'])) {
    $idpl = $_POST['idpl'];

    $query = mysqli_query($koneksi,"DELETE FROM pelanggan where id_pelanggan='$idpl'");

    if ($query) {
        header('location: pelanggan.php');
    }else{
        echo "
            <script>
                alert('Gagal Edit pelanggan!');
                window.location.href='pelanggan.php'
            </script>
        ";
    }
}