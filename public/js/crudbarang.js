$(document).ready(function() {
    // Fungsi untuk pencarian barang (tanpa mengubah URL)
    $('#search-barang').on('input', function() {
        var searchTerm = $(this).val().toLowerCase();  // Membuat input pencarian menjadi lowercase

        // Looping untuk menyembunyikan atau menampilkan card barang berdasarkan nama
        $('.card-barang').each(function() {
            var itemName = $(this).find('.item-name').text().toLowerCase();

            if (itemName.includes(searchTerm)) {
                $(this).show();  // Menampilkan barang yang cocok
            } else {
                $(this).hide();  // Menyembunyikan barang yang tidak cocok
            }
        });
    });
});
