$(document).ready(function(){
    uihelper();

    $('#tambah-buku').click(onTambahBukuClicked);
});

function onTambahBukuClicked(e){
    generateModal(configModal.tambahBuku.modalId, configModal.tambahBuku.wrapper, configModal.tambahBuku.opt);
}