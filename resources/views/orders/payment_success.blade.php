<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-transparent">
    <!-- Halaman ini dibuat kosong agar transparan dan langsung memberikan sinyal sukses ke dashboard -->
    <script>
        // Langsung kirim sinyal sukses ke dashboard induk
        window.parent.postMessage('payment-success', '*');
    </script>
</body>
</html>
