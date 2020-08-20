$(document).ready(function () {
    uihelper();

    $('#tambah-buku').click(function () {
        generateModal(configModal.tambahBuku.modalId, configModal.tambahBuku.wrapper, configModal.tambahBuku.opt);
    });
});
