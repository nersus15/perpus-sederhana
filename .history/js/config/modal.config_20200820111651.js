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
            saatBuka: () => {
                
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
                          '<p><input type="checkbox" name="jenis" value="Pendidikan" /> Pendidikan </p>' +
                          '<p><input type="checkbox" name="jenis" value="Komik" /> Komik </p>' +
                          '<p><input type="checkbox" name="jenis" value="Hiburan" /> Hiburan </p>'
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