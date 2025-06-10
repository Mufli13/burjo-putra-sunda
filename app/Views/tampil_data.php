<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Mahasiswa</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <div class="profile-container">
        <h1>Data Mahasiswa dari Database</h1>
        <table style="width: 100%; text-align: left; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th style="padding: 12px; border-bottom: 2px solid #ddd;">NIM</th>
                    <th style="padding: 12px; border-bottom: 2px solid #ddd;">Nama</th>
                    <th style="padding: 12px; border-bottom: 2px solid #ddd;">Program Studi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mahasiswa as $mhs): ?>
                <tr>
                    <td style="padding: 12px; border-bottom: 1px solid #eee;"><?= esc($mhs['nim']); ?></td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee;"><?= esc($mhs['nama']); ?></td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee;"><?= esc($mhs['prodi']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>