// public/js/crud-barang.js

$(document).ready(function() {
    // Fungsi untuk pencarian barang
    $('#search-barang').on('input', function() {
        var searchTerm = $(this).val().toLowerCase();

        // Looping untuk menyembunyikan atau menampilkan card barang berdasarkan nama
        $('.card-barang').each(function() {
            var itemName = $(this).find('.item-name').text().toLowerCase();

            if (itemName.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});
