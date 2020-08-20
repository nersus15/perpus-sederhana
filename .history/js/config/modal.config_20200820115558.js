var configModal = {
    "tambahBuku": {
        modalId: "modal-form-tambah-buku",
        wrapper: ".generated-modals",
        opt: {
            type: 'form',
            ajax: false,
            open: true,
            destroy: true,
            modalPos: 'right',
            saatBuka: function () {
                $('#pendidikan, #hiburan, #komik').click(async function () {
                    var ini = $(this);
                    var id = ini.attr('id');
                    var kode = '';
                    var jumlahBuku = await fetch(path + '/api.php?func=databuku&&jenis=' + id, {method: 'GET'})
                        .then(res => res.json()).then(res => res.data);
                    if (id == 'pendidikan')
                        kode = 'P00' + parseInt(jumlahBuku + 1);
                    if (id == 'hiburan')
                        kode = 'H00' + parseInt(jumlahBuku + 1);
                    if (id == 'komik')
                        kode = 'K00' + parseInt(jumlahBuku + 1);
                    if(kode)
                        $('#kode').val(kode);
                });
            },
            formOpt: {
                enctype: 'multipart/form-data',
                formId: "form-tambah-buku",
                formAct: "",
                formMethod: 'POST',
            },
            modalTitle: "Tambah Buku",
            modalBody: {
                input: [
                    {
                        label: 'Kode Buku', placeholder: 'Masukkan kode buku',
                        type: 'text', name: 'kode', id: 'kode', attr: 'required readonly'
                    },
                    {
                        label: 'Judul Buku', placeholder: 'Masukkan Judul',
                        type: 'text', name: 'judul', id: 'judul', attr: 'required'
                    },
                    {
                        label: 'Penerbit Buku', placeholder: 'Masukkan Penerbit',
                        type: 'text', name: 'penerbit', id: 'penerbit', attr: 'required'
                    },
                    {
                        label: 'Jumlah Buku', placeholder: 'Masukkan Jumlah',
                        type: 'number', name: 'jumlah', id: 'jumlah', attr: 'required'
                    },
                    {
                        type: 'custom', text: '<label for="jenis">Jenis Buku : </label>' +
                            '<p><input type="radio" name="jenis" id="pendidikan" value="Pendidikan" /> Pendidikan </p>' +
                            '<p><input type="radio" name="jenis" value="Komik" id="komik" /> Komik </p>' +
                            '<p><input type="radio" name="jenis" value="Komik" id="hiburan"/> Hiburan </p>'
                    },
                    {
                        type: 'hidden', name: 'submit', value: true
                    }


                ],
                buttons: [
                    { type: 'button', data: 'data-dismiss="modal"', text: 'Batal', id: "batal", class: "btn btn-empty" },
                    { type: 'submit', text: 'Simpan', id: "simpan", class: "btn btn btn-primary" }
                ],
            },
        }
    },
}