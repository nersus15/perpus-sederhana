$(document).ready(function () {
    uihelper();

    $('#tambah-buku').click(function () {
        alert('ada')
        generateModal(configModal.tambahBuku.modalId, configModal.tambahBuku.wrapper, configModal.tambahBuku.opt);

    });
});
