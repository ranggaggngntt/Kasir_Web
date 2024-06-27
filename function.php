<?php
session_start();

// Database connection
$connection = mysqli_connect('localhost', 'root', '', 'kasir');

if (isset($_POST['login'])) {
    // Initialize variables
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check user credentials
    $query = mysqli_query($connection, "SELECT * FROM user WHERE username='$username' AND password='$password'");
    $userCount = mysqli_num_rows($query);

    if ($userCount > 0) {
        // Successful login
        $_SESSION['login'] = true;
        $_SESSION['username'] = $username;
        header('location:index.php');
    } else {
        // Failed login
        echo '
        <script>
        alert("Username or Password is incorrect")
        window.location.href="login.php"
        </script>';
    }
}

if (isset($_POST['register'])) {

    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    
    $checkQuery = mysqli_query($connection, "SELECT * FROM user WHERE username='$username'");
    $existingUserCount = mysqli_num_rows($checkQuery);

    if ($existingUserCount > 0) {
        echo '
        <script>
            alert("Username sudah ada. Pilih username yang lain.");
            window.location.href="register.php";
        </script>';
    } else {
        $insertQuery = mysqli_query($connection, "INSERT INTO user (username, password) VALUES ('$username', '$password')");

        if ($insertQuery) {
            echo '
            <script>
                alert("Registrasi berhasil!");
                window.location.href="login.php";
            </script>';
        } else {
            echo '
            <script>
                alert("Error during registration. Please try again.");
                window.location.href="register.php";
            </script>';
        }
    }
}



if (isset($_POST['tambahproduk'])) {
    // Initialize variables
    $productName = $_POST['nama_produk'];
    $description = $_POST['deskripsi'];
    $price = $_POST['harga'];
    $stock = $_POST['stock'];

    // Insert new product
    $insertProduct = mysqli_query($connection, "INSERT INTO produk (nama_produk, deskripsi, harga, stock)
    VALUES ('$productName', '$description', '$price', '$stock')");

    if ($insertProduct) {
        header('location:stock.php');
    } else {
        echo '
        <script>
        alert("Failed to add product")
        window.location.href="stock.php"
        </script>';
    }
}

if (isset($_POST['tambahpelanggan'])) {
    // Initialize variables
    $customerName = $_POST['nama_pelanggan'];
    $phone = $_POST['notelp'];
    $address = $_POST['alamat'];

    // Insert new customer
    $insertCustomer = mysqli_query($connection, "INSERT INTO pelanggan (nama_pelanggan, notelp, alamat)
    VALUES ('$customerName', '$phone', '$address')");

    if ($insertCustomer) {
        header('location:pelanggan.php');
    } else {
        echo '
        <script>
        alert("Failed to add customer")
        window.location.href="pelanggan.php"
        </script>';
    }
}

if (isset($_POST['tambahpesanan'])) {
    // Initialize variables
    $customerId = $_POST['id_pelanggan'];

    // Insert new order
    $insertOrder = mysqli_query($connection, "INSERT INTO pesanan (id_pelanggan) 
    VALUES ('$customerId')");

    if ($insertOrder) {
        header('location:index.php');
    } else {
        echo '
        <script>
        alert("Failed to add order")
        window.location.href="index.php"
        </script>';
    }
}

if (isset($_POST['addproduk'])) {
    var_dump($_POST);
    // Initialize variables
    $productId = $_POST['id_produk'];
    $orderId = $_POST['idp'];
    $quantity = $_POST['qty'];

    // Check current stock
    $stockQuery = mysqli_query($connection, "SELECT * FROM produk WHERE id_produk='$productId'");
    $stockResult = mysqli_fetch_array($stockQuery);
    $currentStock = $stockResult['stock'];

    if ($currentStock >= $quantity) {
        // Update stock
        $newStock = $currentStock - $quantity;

        // Insert order details and update product stock
        $insertDetail = mysqli_query($connection, "INSERT INTO detail_pesanan (id_pesanan, id_produk, qty) 
        VALUES ('$orderId', '$productId', '$quantity')");
        $updateStock = mysqli_query($connection, "UPDATE produk SET stock='$newStock' WHERE id_produk='$productId'");

        if ($insertDetail && $updateStock) {
            header('location:view.php?idp=' . $orderId);
        } else {
            echo '
            <script>
            alert("Failed to add product")
            window.location.href="view.php?idp=' . $orderId . '"
            </script>';
        }
    } else {
        // Insufficient stock
        echo '
        <script>
        alert("Insufficient stock")
        window.location.href="view.php?idp=' . $orderId . '"
        </script>';
    }
}

// Delete order product
if (isset($_POST['hapusprodukpesanan'])) {
    $orderDetailId = $_POST['iddetail'];
    $productId = $_POST['idpr'];
    $orderId = $_POST['idp'];

    // Check current quantity
    $quantityQuery = mysqli_query($connection, "SELECT * FROM detail_pesanan WHERE id_detailpesanan='$orderDetailId'");
    $quantityResult = mysqli_fetch_array($quantityQuery);
    $currentQuantity = $quantityResult['qty'];

    // Check current stock
    $stockQuery = mysqli_query($connection, "SELECT * FROM produk WHERE id_produk='$productId'");
    $stockResult = mysqli_fetch_array($stockQuery);
    $currentStock = $stockResult['stock'];

    // Update stock
    $newStock = $currentStock + $currentQuantity;

    $updateStock = mysqli_query($connection, "UPDATE produk SET stock='$newStock' WHERE id_produk='$productId'");
    $deleteDetail = mysqli_query($connection, "DELETE FROM detail_pesanan WHERE id_produk='$productId' AND id_detailpesanan='$orderDetailId'");

    if ($updateStock && $deleteDetail) {
        header('location:view.php?idp=' . $orderId);
    } else {
        echo '
        <script>
        alert("Failed to update stock")
        window.location.href="view.php?idp=' . $orderId . '"
        </script>';
    }
}

// Edit product
if (isset($_POST['editproduk'])) {
    $productName = $_POST['nama_produk'];
    $description = $_POST['deskripsi'];
    $price = $_POST['harga'];
    $productId = $_POST['id_produk'];

    $updateProduct = mysqli_query($connection, "UPDATE produk SET nama_produk='$productName', deskripsi='$description', harga='$price' WHERE id_produk='$productId'");

    if ($updateProduct) {
        header('location:stock.php');
    } else {
        echo '
        <script>
        alert("Failed to edit product")
        window.location.href="stock.php"
        </script>';
    }
}

if (isset($_POST['editdetailpesanan'])) {
    $quantity = $_POST['qty'];
    $orderDetailId = $_POST['iddetail'];
    $productId = $_POST['idpr'];
    $orderId = $_POST['idp'];

    // Check current quantity
    $quantityQuery = mysqli_query($connection, "SELECT * FROM detail_pesanan WHERE id_detailpesanan='$orderDetailId'");
    $quantityResult = mysqli_fetch_array($quantityQuery);
    $currentQuantity = $quantityResult['qty'];

    // Check current stock
    $stockQuery = mysqli_query($connection, "SELECT * FROM produk WHERE id_produk='$productId'");
    $stockResult = mysqli_fetch_array($stockQuery);
    $currentStock = $stockResult['stock'];

    if ($quantity >= $currentQuantity) {
        $difference = $quantity - $currentQuantity;
        $newStock = $currentStock - $difference;

        $updateDetail = mysqli_query($connection, "UPDATE detail_pesanan SET qty='$quantity' WHERE id_detailpesanan='$orderDetailId'");
        $updateStock = mysqli_query($connection, "UPDATE produk SET stock='$newStock' WHERE id_produk='$productId'");

        if ($updateDetail && $updateStock) {
            header('location:view.php?idp=' . $orderId);
        } else {
            echo "
            <script>
                alert('Failed to edit order detail!');
                window.location.href='view.php?idp=$orderId';
            </script>
            ";
        }
    } else {
        $difference = $currentQuantity - $quantity;
        $newStock = $currentStock + $difference;

        $updateDetail = mysqli_query($connection, "UPDATE detail_pesanan SET qty='$quantity' WHERE id_detailpesanan='$orderDetailId'");
        $updateStock = mysqli_query($connection, "UPDATE produk SET stock='$newStock' WHERE id_produk='$productId'");

        if ($updateDetail && $updateStock) {
            header('location:view.php?idp=' . $orderId);
        } else {
            echo "
            <script>
                alert('Failed to edit order detail!');
                window.location.href='view.php?idp=$orderId';
            </script>
            ";
        }
    }
}

if (isset($_POST['hapusproduk'])) {
    $productId = $_POST['id_produk'];

    $deleteProduct = mysqli_query($connection, "DELETE FROM produk WHERE id_produk='$productId'");

    if ($deleteProduct) {
        header('location:stock.php');
    } else {
        echo "
        <script>
            alert('Failed to delete product!');
            window.location.href='view.php?idp=$orderId'
        </script>
        ";
    }
}

if (isset($_POST['hapuspesanan'])) {
    $orderId = $_POST['idp'];

    $orderDetailsQuery = mysqli_query($connection, "SELECT * FROM detail_pesanan WHERE id_pesanan='$orderId'");

    while ($orderDetail = mysqli_fetch_array($orderDetailsQuery)) {
        $quantity = $orderDetail['qty'];
        $productId = $orderDetail['id_produk'];
        $orderDetailId = $orderDetail['id_detailpesanan'];

        // Check current stock
        $stockQuery = mysqli_query($connection, "SELECT * FROM produk WHERE id_produk='$productId'");
        $stockResult = mysqli_fetch_array($stockQuery);
        $currentStock = $stockResult['stock'];

        $newStock = $currentStock + $quantity;

        $updateStock = mysqli_query($connection, "UPDATE produk SET stock='$newStock' WHERE id_produk='$productId'");
        $deleteDetail = mysqli_query($connection, "DELETE FROM detail_pesanan WHERE id_detailpesanan='$orderDetailId'");
    }

    $deleteOrder = mysqli_query($connection, "DELETE FROM pesanan WHERE id_pesanan='$orderId'");

    if ($updateStock && $deleteDetail && $deleteOrder) {
        header('location:index.php');
    } else if ($deleteOrder) {
        echo "
        <script>
            alert('Order deleted successfully!');
            window.location.href='index.php'
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Failed to delete order!');
            window.location.href='index.php'
        </script>
        ";
    }
}

// Add incoming product
if (isset($_POST['barangmasuk'])) {
    $productId = $_POST['id_produk'];
    $quantity = $_POST['qty'];

    // Check current stock
    $stockQuery = mysqli_query($connection, "SELECT * FROM produk WHERE id_produk='$productId'");
    $stockResult = mysqli_fetch_array($stockQuery);
    $currentStock = $stockResult['stock'];

    // Update stock
    $newStock = $currentStock + $quantity;

    $insertIncoming = mysqli_query($connection, "INSERT INTO masuk (id_produk, qty) VALUES ('$productId', '$quantity')");
    $updateStock = mysqli_query($connection, "UPDATE produk SET stock='$newStock' WHERE id_produk='$productId'");

    if ($insertIncoming && $updateStock) {
        header('location:masuk.php');
    } else {
        echo "
        <script>
            alert('Failed to add incoming product!');
            window.location.href='masuk.php';
        </script>
        ";
    }
}

if (isset($_POST['editmasuk'])) {
    $quantity = $_POST['qty'];
    $incomingId = $_POST['id_masuk'];
    $productId = $_POST['id_produk'];

    // Check current quantity
    $quantityQuery = mysqli_query($connection, "SELECT * FROM masuk WHERE id_masuk='$incomingId'");
    $quantityResult = mysqli_fetch_array($quantityQuery);
    $currentQuantity = $quantityResult['qty'];

    // Check current stock
    $stockQuery = mysqli_query($connection, "SELECT * FROM produk WHERE id_produk='$productId'");
    $stockResult = mysqli_fetch_array($stockQuery);
    $currentStock = $stockResult['stock'];

    if ($quantity >= $currentQuantity) {
        $difference = $quantity - $currentQuantity;
        $newStock = $currentStock + $difference;

        $updateIncoming = mysqli_query($connection, "UPDATE masuk SET qty='$quantity' WHERE id_masuk='$incomingId'");
        $updateStock = mysqli_query($connection, "UPDATE produk SET stock='$newStock' WHERE id_produk='$productId'");

        if ($updateIncoming && $updateStock) {
            header('location:masuk.php');
        } else {
            echo "
            <script>
                alert('Failed to edit incoming product!');
                window.location.href='masuk.php'
            </script>
            ";
        }
    } else {
        $difference = $currentQuantity - $quantity;
        $newStock = $currentStock - $difference;

        $updateIncoming = mysqli_query($connection, "UPDATE masuk SET qty='$quantity' WHERE id_masuk='$incomingId'");
        $updateStock = mysqli_query($connection, "UPDATE produk SET stock='$newStock' WHERE id_produk='$productId'");

        if ($updateIncoming && $updateStock) {
            header('location:masuk.php');
        } else {
            echo "
            <script>
                alert('Failed to edit incoming product!');
                window.location.href='masuk.php'
            </script>
            ";
        }
    }
}

// Delete incoming product
if (isset($_POST['hapusdatabarangmasuk'])) {
    $incomingId = $_POST['id_masuk'];
    $productId = $_POST['id_produk'];

    // Check current quantity
    $quantityQuery = mysqli_query($connection, "SELECT * FROM masuk WHERE id_masuk='$incomingId'");
    $quantityResult = mysqli_fetch_array($quantityQuery);
    $currentQuantity = $quantityResult['qty'];

    // Check current stock
    $stockQuery = mysqli_query($connection, "SELECT * FROM produk WHERE id_produk='$productId'");
    $stockResult = mysqli_fetch_array($stockQuery);
    $currentStock = $stockResult['stock'];

    // Update stock
    $newStock = $currentStock - $currentQuantity;

    $deleteIncoming = mysqli_query($connection, "DELETE FROM masuk WHERE id_masuk='$incomingId'");
    $updateStock = mysqli_query($connection, "UPDATE produk SET stock='$newStock' WHERE id_produk='$productId'");

    if ($deleteIncoming && $updateStock) {
        header('location:masuk.php');
    } else {
        echo "
        <script>
            alert('Failed to delete incoming product!');
            window.location.href='masuk.php'
        </script>
        ";
    }
}

// Edit customer
if (isset($_POST['editpelanggan'])) {
    $customerName = $_POST['nama_pelanggan'];
    $phone = $_POST['notelp'];
    $address = $_POST['alamat'];
    $customerId = $_POST['id_pelanggan'];

    $updateCustomer = mysqli_query($connection, "UPDATE pelanggan SET nama_pelanggan='$customerName', notelp='$phone', alamat='$address' WHERE id_pelanggan='$customerId'");

    if ($updateCustomer) {
        header('location:pelanggan.php');
    } else {
        echo "
        <script>
            alert('Failed to edit customer!');
            window.location.href='pelanggan.php'
        </script>
        ";
    }
}

// Delete customer
if (isset($_POST['hapuspelanggan'])) {
    $customerId = $_POST['id_pelanggan'];

    $deleteCustomer = mysqli_query($connection, "DELETE FROM pelanggan WHERE id_pelanggan='$customerId'");

    if ($deleteCustomer) {
        header('location:pelanggan.php');
    } else {
        echo "
        <script>
            alert('Failed to delete customer!');
            window.location.href='pelanggan.php'
        </script>
        ";
    }
}