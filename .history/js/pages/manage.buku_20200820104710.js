$(document).ready(function(){
    uihelper();

    $('#tambah-buku').click(onTambahBukuClicked);
});

function onTambahBukuClicked(e){
    generateModal();
}