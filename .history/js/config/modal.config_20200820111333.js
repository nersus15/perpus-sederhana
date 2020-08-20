var configModal = {
    "tambahBuku": {
        modalId: "modal-form-tambah-buku",
        wrapper: ".generated-modals",
        opt: {
            type: 'form',
            ajax: false,
            rules: [
                {
                    name: 'noSpace',
                    method: function (value, element) { return value.indexOf(" ") < 0; },
                    message: "No space please",
                    field: 'user'
                }
            ],
            open: true,
            destroy: true,
            modalPos: 'right',
            saatBuka: () => {
                var token = $('meta[name="_token"]').attr('content');
                $("#" + modalConf.formregister.opt.formOpt.formId + " #token").val(token);
                $('#daftar').click(function () {
                    const { modalId, wrapper, opt } = modalConf.formregister;
                    UiHelper.generateModal(modalId, wrapper, opt);
                });


            },
            formOpt: {
                enctype: 'multipart/form-data',
                formId: "form-login",
                formAct: "/api/login",
                formMethod: 'POST',
            },
            modalTitle: "Tambah Buku",
            modalBody: {
                input: [
                    {
                        label: 'Kode Buku', placeholder: 'Masukkan kode buku',
                        type: 'text', name: 'kode', id: 'kode', attr: 'required read-only'
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
                    

                ],
                buttons: [
                    { type: 'button', data: 'data-dismiss="modal"', text: 'Batal', id: "batal", class: "btn btn-empty" },
                    { type: 'submit', text: 'Simpan', id: "simpan", class: "btn btn btn-primary" }
                ],
            },
        }
    },
}