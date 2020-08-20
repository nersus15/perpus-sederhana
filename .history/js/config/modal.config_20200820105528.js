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
                        label: 'Username atau Email', placeholder: 'Masukkan Username atau Email',
                        type: 'text', name: 'user', id: 'user', attr: 'required'
                    },
                    {
                        label: 'Password', placeholder: 'Masukkan Password',
                        type: 'password', name: 'pass', id: 'pass', attr: 'required'
                    },
                    {
                        type: 'hidden', name: '_token', id: 'token'
                    }
                ],
                buttons: [
                    { type: 'button', text: 'Daftar', id: "daftar", class: "btn btn-empty" },
                    { type: 'submit', text: 'Masuk', id: "login", class: "btn btn btn-primary" }
                ],
            },
        }
    },
}