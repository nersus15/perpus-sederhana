var configModal = {
    "formlogin": {
        modalId: "modal-form-login",
        wrapper: ".generated-modals",
        opt: {
            type: 'form',
            ajax: true,
            rules: [
                {
                    name: 'noSpace',
                    method: function (value, element) { return value.indexOf(" ") < 0; },
                    message: "No space please",
                    field: 'user'
                }
            ],
            sebelumSubmit: function () {
                $('body').addClass('show-spinner');
                $('#login').prop('disabled', true);
            },
            submitSuccess: function (res) {
                $('body').removeClass('show-spinner');
                $('#login').prop('disabled', false);
                if (!res.data)
                    $('#' + modalConf.formlogin.opt.formOpt.formId + ' #alert_danger').html(res.massage).show();
                else {
                    if (res.data.role == 'pembeli' || res.data.role == 'pedagang')
                        window.location.reload();
                    else if (res.data.role == 'admin')
                        window.location.replace(path + '/admin');
                }
            },
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
            saatTutup: () => {
                $("#daftar").off('click');
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