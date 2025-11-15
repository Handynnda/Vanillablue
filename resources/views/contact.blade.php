<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim(strip_tags($_POST['name'] ?? ''));
    $email = trim(filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL));
    $message = trim(htmlspecialchars($_POST['message'] ?? ''));

    if ($name && $email && $message) {
        $line = date('Y-m-d H:i:s') . " | $name | $email | " . str_replace(["\r","\n"], [' ', ' '], $message) . PHP_EOL;
        file_put_contents(__DIR__ . '/messages.txt', $line, FILE_APPEND | LOCK_EX);
        $success = true;
    } else {
        $success = false;
    }
} else {
    header('Location: index.php');
    exit;
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Pesan Terkirim</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include 'header.php'; ?>
<main class="section">
  <div class="container">
    <?php if (!empty($success)): ?>
      <h2>Terima kasih, pesan Anda telah dikirim!</h2>
      <p>Kami akan menghubungi Anda melalui email: <?php echo htmlspecialchars($email); ?></p>
      <p><a href="index.php">Kembali ke beranda</a></p>
    <?php else: ?>
      <h2>Gagal mengirim pesan.</h2>
      <p>Periksa kembali data dan coba lagi.</p>
      <p><a href="index.php">Kembali</a></p>
    <?php endif; ?>
  </div>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
