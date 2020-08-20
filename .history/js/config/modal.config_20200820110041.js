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
                customBody : `
                <div class="form-group">
                <label for="kode">Kode Buku</label>
                <input placeholder="Kode Buku" class="form-control" id="kode" type="text" name="kode" autocomplete="off" required>
              </div>
              <div class="form-group">
                <label for="judul">Judul Buku</label>
                <input placeholder="Judul Buku" class="form-control" id="judul" type="text" name="judul" autocomplete="off" required>
              </div>
              <div class="form-group">
                <label for="penerbit">Penerbit Buku</label>
                <input placeholder="Penerbit Buku" class="form-control" id="penerbit" type="text" name="penerbit" autocomplete="off" required>
              </div>
              <div class="form-group">
                <label for="jumlah">Jumlah Buku</label>
                <input placeholder="Jumlah Buku" class="form-control" id="jumlah" type="text" name="jumlah" autocomplete="off" required>
              </div>
              <div class="form-group">
                <label for="jenis">Jenis Buku : </label>
                <form action="managebuku.php" method="get">
                  <p><input type="checkbox" name="jenis" value="Pendidikan" /> Pendidikan </p>
                  <p><input type="checkbox" name="jenis" value="Komik" /> Komik </p>
                  <p><input type="checkbox" name="jenis" value="Hiburan" /> Hiburan </p>
              </div>
                `
            },
        }
    },
}