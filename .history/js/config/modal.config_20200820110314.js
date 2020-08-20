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
            modalTitle: "Login",
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
                        label: 'Judul Buku', placeholder: 'Masukkan Judul',
                        type: 'text', name: 'judul', id: 'judul', attr: 'required'
                    },
                    {
                        label: 'Judul Buku', placeholder: 'Masukkan Judul',
                        type: 'text', name: 'judul', id: 'judul', attr: 'required'
                    },
                },
                buttons: [
                    { type: 'button', text: 'Daftar', id: "daftar", class: "btn btn-empty" },
                    { type: 'submit', text: 'Masuk', id: "login", class: "btn btn btn-primary" }
                ],
            },
        }
    },
}