<form action="<?= base_url('admin/simpan_menu') ?>" method="post">
    <input type="text" name="name" placeholder="Nama Menu (Contoh: Nasi Ayam Bali)" required>
    <select name="sub_category">
        <option value="ANEKA NASI TELUR">ANEKA NASI TELUR</option>
        <option value="ANEKA NASI AYAM">ANEKA NASI AYAM</option>
        <option value="MINUMAN">MINUMAN</option>
    </select>
    <input type="number" name="price" placeholder="Harga (Contoh: 15000)" required>
    <button type="submit">Tambah Menu</button>
</form>