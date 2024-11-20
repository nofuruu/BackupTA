<?php
// Sertakan file koneksi database
include '../../../koneksi.php';

// Periksa apakah id_kendaraan diterima melalui POST
if (isset($_POST['id_kendaraan'])) {
    $id_kendaraan = $_POST['id_kendaraan'];

    // Ambil detail kendaraan dari database
    $query = "SELECT * FROM kendaraan WHERE id_kendaraan = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id_kendaraan);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo '<div class="alert alert-warning">Detail kendaraan tidak ditemukan.</div>';
        exit;
    }

    // Tutup statement
    $stmt->close();
} else {
    echo '<div class="alert alert-danger">Tidak ada kendaraan yang dipilih.</div>';
    exit;
}

// Tutup koneksi
$koneksi->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../../public/css/checkout.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Checkout</title>
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Checkout</h2>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Detail Produk</h5>
            <p><strong>Nama Kendaraan:</strong> <?php echo htmlspecialchars($row['nm_kendaraan']); ?></p>
            <p><strong>Harga:</strong> Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
            <p><strong>Jenis Kendaraan:</strong> <?php echo htmlspecialchars($row['jenis_kendaraan']); ?></p>          
        </div>
    </div>

    <form action="../function/process-checkout.php" method="POST">
        <input type="hidden" name="id_kendaraan" value="<?php echo htmlspecialchars($id_kendaraan); ?>">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
        </div>


        <div id="postal-code" class="additional-items" style="display: none;">
    <div class="mb-3">
        <label for="kode_pos" class="form-label">Kode Pos</label>
        <input type="text" class="form-control" id="kode_pos" name="kode_pos" placeholder="Masukkan Kode Pos">
    </div>
</div>


<div class="mb-3">
    <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
    <select class="form-control" id="metode_pembayaran" name="metode_pembayaran" required>
        <option value="cod">-</option>
        <option value="transfer_bank">Transfer Bank</option>
        <option value="kartu_kredit">Kartu Kredit(Belum Tersedia)</option>
        <option value="e-wallet">E-Wallet (Belum Tersedia)</option>
    </select>
</div>

<!-- Additional items for Transfer Bank -->
<div id="bank-details" class="additional-items" style="display: none;">
    <div class="mb-3">
        <label for="bank_name" class="form-label">Nama Bank</label>
        <select class="form-control" id="bank_name" name="bank_name">
            <option value="bca">
                <img src="../../../public/resource/icons/bca.png" alt="BCA" style="width: 10rem; height: 5rem; margin-right: 10px;"> BCA
            </option>
            <option value="mandiri">
                <img src="../../../public/resource/icons/mandiri.png" alt="Mandiri" style="width: 10rem; height: 5rem; margin-right: 10px;"> Mandiri
            </option>
            <option value="bni">
                <img src="../../../public/resource/icons/bni.png" alt="BNI" style="width: 10rem; height: 5rem; margin-right: 10px;"> BNI
            </option>
            <option value="bri">
                <img src="../../../public/resource/icons/bri.png" alt="BRI" style="width: 10rem; height: 5rem; margin-right: 10px;"> BRI
            </option>
        </select>
    </div>
</div>

<!-- Additional items for Kartu Kredit -->
<div id="credit-card-details" class="additional-items" style="display: none;">
    <div class="mb-3">
        <label for="credit_card_type" class="form-label">Jenis Kartu Kredit</label>
        <select class="form-control" id="credit_card_type" name="credit_card_type">
            <option value="visa">
                <img src="../../../public/resource/icons/visa.png" alt="Visa" style="width: 10rem; height: 5rem; margin-right: 10px;"> Visa
            </option>
            <option value="mastercard">
                <img src="../../../public/resource/icons/mastercard.png" alt="MasterCard" style="width: 10rem; height: 5rem; margin-right: 10px;"> MasterCard
            </option>
            <option value="american_express">
                <img src="../../../public/resource/icons/american_express.png" alt="American Express" style="width: 10rem; height: 5rem; margin-right: 10px;"> American Express
            </option>
        </select>
    </div>
</div>

<!-- Additional items for E-Wallet -->
<div id="wallet-details" class="additional-items" style="display: none;">
    <div class="mb-3">
        <label for="wallet_type" class="form-label">Pilih E-Wallet</label>
        <select class="form-control" id="wallet_type" name="wallet_type">
            <option value="ovo">
                <img src="../../../public/resource/icons/ovo.png" alt="OVO" style="width: 10rem; height: 5rem; margin-right: 10px;"> OVO
            </option>
            <option value="gopay">
                <img src="../../../public/resource/icons/gopay.png" alt="GoPay" style="width: 10rem; height: 5rem; margin-right: 10px;"> GoPay
            </option>
            <option value="dana">
                <img src="../../../public/resource/icons/dana.png" alt="DANA" style="width: 10rem; height: 5rem; margin-right: 10px;"> DANA
            </option>
        </select>
    </div>
</div>

<!-- Additional items for Delivery Method -->
<div id="delivery-method" class="additional-items" style="display: none;">
    <div class="mb-3">
        <label for="metode_pengiriman" class="form-label">Metode Pengiriman Kendaraan</label>
        <select class="form-control" id="metode_pengiriman" name="metode_pengiriman" required>
            <option value="kurir">Kurir Kendaraan</option>
            <option value="ambil_sendiri">Ambil Sendiri</option>
        </select>
    </div>
</div>

<!-- Field for Postal Code (Only for Ojek Online or Kurir) -->
<div id="postal-code" class="additional-items" style="display: none;">
    <div class="mb-3">
        <label for="kode_pos" class="form-label">Kode Pos</label>
        <input type="text" class="form-control" id="kode_pos" name="kode_pos" placeholder="Masukkan Kode Pos">
    </div>
</div>

<button type="submit" class="btn btn-success">Proses Pembayaran</button>
<a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
const metodePembayaran = document.getElementById('metode_pembayaran');
const bankDetails = document.getElementById('bank-details');
const creditCardDetails = document.getElementById('credit-card-details');
const walletDetails = document.getElementById('wallet-details');
const deliveryMethod = document.getElementById('delivery-method');
const postalCode = document.getElementById('postal-code');  // Add this line to access the postal code field

// Event listener ketika nilai metode pembayaran berubah
metodePembayaran.addEventListener('change', function() {
    // Sembunyikan semua item tambahan terlebih dahulu
    bankDetails.style.display = 'none';
    creditCardDetails.style.display = 'none';
    walletDetails.style.display = 'none';
    deliveryMethod.style.display = 'none';
    postalCode.style.display = 'none'; // Sembunyikan kode pos terlebih dahulu

    // Tampilkan item tambahan berdasarkan pilihan
    if (metodePembayaran.value === 'transfer_bank') {
        bankDetails.style.display = 'block';
        deliveryMethod.style.display = 'block'; // Tampilkan metode pengiriman jika pilih transfer bank
    } else if (metodePembayaran.value === 'kartu_kredit') {
        creditCardDetails.style.display = 'block';
        deliveryMethod.style.display = 'block'; // Tampilkan metode pengiriman jika pilih kartu kredit
    } else if (metodePembayaran.value === 'e-wallet') {
        walletDetails.style.display = 'block';
        deliveryMethod.style.display = 'block'; // Tampilkan metode pengiriman jika pilih e-wallet
    } else if (metodePembayaran.value === 'cod') {
        // Jangan tampilkan metode pengiriman jika pilih cek di gerai
        deliveryMethod.style.display = 'none';
    }
});
</script>
<script>
    // Event listener ketika nilai metode pengiriman berubah
document.getElementById('metode_pengiriman').addEventListener('change', function() {
    // Sembunyikan kode pos terlebih dahulu
    postalCode.style.display = 'none';

    // Tampilkan kode pos jika memilih Ojek Online atau Kurir
    if (this.value === 'ojek_online' || this.value === 'kurir') {
        postalCode.style.display = 'block';
    }
});
</script>
<script>
   $(document).ready(function() {
    // Initialize Select2 for all dropdowns with images
    $('#wallet_type').select2({
        templateResult: function(state) {
            // Show image with text for wallet type
            if (!state.id) {
                return state.text;
            }
            var $state = $('<span><img src="../../../public/resource/icons/' + state.element.value.toLowerCase() + '.png" style="width: 50px; height: 50px; margin-right: 10px;"> ' + state.text + '</span>');
            return $state;
        }
    });

    $('#bank_name').select2({
        templateResult: function(state) {
            // Show image with text for bank names
            if (!state.id) {
                return state.text;
            }
            var $state = $('<span><img src="../../../public/resource/icons/' + state.element.value.toLowerCase() + '.png" style="width: 50px; height: 50px; margin-right: 10px;"> ' + state.text + '</span>');
            return $state;
        }
    });

    $('#credit_card_type').select2({
        templateResult: function(state) {
            // Show image with text for credit card types
            if (!state.id) {
                return state.text;
            }
            var $state = $('<span><img src="../../../public/resource/icons/' + state.element.value.toLowerCase() + '.png" style="width: 50px; height: 50px; margin-right: 10px;"> ' + state.text + '</span>');
            return $state;
        }
    });

    $('#metode_pengiriman').select2({
        templateResult: function(state) {
            // Show image with text for delivery methods (if necessary)
            return state.text;
        }
    });
});

</script>




</script>
</body>
</html>
