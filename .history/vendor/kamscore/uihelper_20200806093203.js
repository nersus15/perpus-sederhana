function uihelper() {
    var _generatedModal = {};
    var _ajaxSubmit = {};
    this.storeModal = function (params) {
        _generatedModal[params.key.toString().replaceAll('-', '_')] = {
            modalid: params.modalid,
            formid: params.formid ? params.formid : '',
            modal: params.modal
        };
    }
    this.storeAjaxSubmit = function (params) {
        _ajaxSubmit[params.key] = params.callback;
    }
    this.getAjaxSumbit = function (key) {
        return _ajaxSubmit[key];
    }
    this.getModal = function (modalid = null) {
        if (modalid) {
            var key = modalid.split('-');
            var key = key.join('_');
            var modal = this.generatedModal[key];
            return { modal: modal.modal, callback: _ajaxSubmit };
        } else
            return _generatedModal;
    }
    this.instance = {
        validator: {}
    };


    this.getInstance = function () {
        return this.instance;
    }
    this.tambahkanBody = function (type, opt) {
        var bodyEl = '';
        var inputEl = "";
        var buttonsEl = "";

        var cardEl = opt.modalBody.card;
        var input = opt.modalBody.input;
        var buttons = opt.modalBody.buttons;


        if (!opt.modalBody.extra)
            opt.modalBody.extra = '';
        if (type == 'form') {
            var form = opt.formOpt;
            if (!form.formId)
                form.formId = 'noId'
            if (!form.enctype)
                form.enctype = '';
            if (!form.formMethod)
                form.formMethod = "POST";
            if (!form.formAttr)
                form.formAttr = '';
            if (!form.formClass)
                form.formClass = '';

            input.forEach(element => {
                if (element.type == 'select')
                    inputEl += this.generateSelect(element);
                else if (element.type == 'custom')
                    inputEl += element.text;
                else
                    inputEl += this.generateInput(element);
            });

            if (buttons) {
                buttons.forEach(el => {
                    var id = !el.id ? "" : el.id;
                    var data = el.data ? el.data : "";
                    buttonsEl += '<button style="margin: 0 5px"' + data + ' type = "' + el.type + '" id = "' + id + '" class = "' + el.class + '">' + el.text + '</button>';
                });
            }
            bodyEl +=
                '<form enctype = "' + form.enctype + '" ' + form.formAttr + ' class="' + form.formClass + '" id ="' + form.formId + '" method = "' + form.formMethod + '" action = "' + form.formAct + '">' +
                '<div id="alert_danger" style="display: none" class="alert alert-danger" role="alert"> </div>' +
                '<div id="alert_success" style="display: none" class="alert alert-success" role="alert"> </div>' +
                inputEl +
                buttonsEl +
                '</form>' +
                opt.modalBody.extra;

            return bodyEl;
        }

        else if (type == 'card group') {
            let card = "";
            if (opt.modalBody.cardDisplay == 'grid')
                card += '<div class="row row-cols-1 row-cols-md-2">';

            cardEl.forEach(element => {
                card += '<div class="col mb-4">';
                card += this.generateCard(element);
                card += '</div>';
            });

            if (opt.modalBody.cardDisplay == 'grid')
                card += '</div>';

            bodyEl += card + '</div>';

        } else if (type == 'inputNF') {
            input.forEach(element => {
                if (element.type == 'select')
                    inputEl += this.generateSelect(element);
                else
                    inputEl += this.generateInput(element);
            });
            bodyEl += inputEl + opt.modalBody.extra;


        } else if (type == 'custom')
            bodyEl = opt.modalBody.customBody;

        return bodyEl;
    }

    this.generateCard = function (el) {
        var card = "";
        var cardHead = "";
        var Topimage = '';
        var Bottomimage = '';
        var Leftimage = '';
        var Rightimage = '';
        var foots = '';
        var links = "";
        var buttons = "";
        var params = ['title', 'footerClass', 'text', 'styles', 'tipe', 'value', 'imagewrapper', 'subtitle', 'class'];
        var badges = '';
        params.forEach(item => {
            if (!el[item])
                el[item] = ''
        });
        if (el.width == 'standart' || !el.width)
            cardHead += '<div id="' + el.id + '" class="card ' + el.class + '" style="width: 18rem;' + el.styles + '">';
        else
            cardHead += '<div id="' + el.id + '" class="card ' + el.class + '" style="width:' + el.width + ';' + el.styles + '">';


        if (el.footer) {
            foots += '<div class="card-footer' + el.footerClass + '">';
            el.footer.forEach(foot => {
                let options = ['pembungkus', 'button', 'btnType', 'tujuan', 'class', 'id', 'text', 'link', 'tag', 'extra']
                options.forEach(item => {
                    if (!foot[item])
                        foot[item] = '';
                });

                if (foot.type == 'button') {
                    if (foot.button)
                        foots += foot.button;

                    else if (foot.text && foot.btnType != 'link')
                        foots += '<button id="' + foot.id + '" type="' + foot.btnType + '"' + foot.extra + ' class= "btn ' + foot.class + '">' + foot.text + '</button>';
                    else if (foot.text && foot.btnType == 'link')
                        foots += '<a id="' + foot.id + '" href="' + foot.tujuan + '"' + foot.extra + ' class= "btn ' + foot.class + '">' + foot.text + '</a>';
                }
                else if (foot.type == 'link') {
                    if (foot.link)
                        foots += foot.button;
                    else if (foot.text && !foot.link)
                        foots += '<a id="' + foot.id + '" href="' + foot.tujuan + '"' + foot.extra + ' class= "' + foot.class + '">' + foot.text + '</a>';
                }
                else if (foot.type == 'text') {
                    if (foot.text && !foot.tag)
                        foots += text;
                    else if (foot.tag) {
                        foots += '<' + foot.tag + 'id="' + foot.id + '"' + foot.extra + ' class ="' + foot.class + '" >' + foot.text + '</' + foot.tag + '>';
                    }
                }
            })
            foots += '</div>';

        }


        if (el.badge) {
            badges += '<div class="position-relative">';
            el.badge.forEach(b => {
                if (!b.id)
                    b.id = '';
                if (!b.class)
                    b.class = '';
                if (!b.extra)
                    b.extra = '';

                badges += '<span' + b.id + 'class="badge badge-pill position-absolute badge-top-left' + b.class + '"' + b.extra + '>' + b.text + '</span>';
            });
            badges += `</div>`;
        }

        if (el.images) {
            el.images.forEach(image => {
                if (!image.styles)
                    image.styles = '';
                if (!image.class)
                    image.class = '';
                if (!image.type)
                    image.type = '';

                if (image.position == 'top' && image.type == 'carousel') {
                    Topimage +=
                        '<div class="slick-item">' +
                        badges
                    '<img class="card-img-top' + image.class + '" style="' + image.styles + '" src="' + image.src + '" alt= "' + image.alt + '" >' +
                        '</div>';
                }

                if (image.position == 'top' && image.type != 'carousel')
                    Topimage += '<img class="card-img-top' + image.class + '" style="' + image.styles + '" src="' + image.src + '" alt= "' + image.alt + '" >';

                if (image.position == 'left')
                    Leftimage += '<img class="card-img-top' + image.class + '" style="' + image.styles + '" src="' + image.src + '" alt= "' + image.alt + '" >';

                if (image.position == 'bottom')
                    Bottomimage += '<img class="card-img-top' + image.class + '" style="' + image.styles + '" src="' + image.src + '" alt= "' + image.alt + '" >';

                if (image.position == 'right')
                    Rightimage += '<img class="card-img-top' + image.class + '" style="' + image.styles + '" src="' + image.src + '" alt= "' + image.alt + '" >';
            });
        }

        if (el.buttons && el.buttons.length > 0) {
            el.buttons.forEach(button => {
                if (!button.class)
                    button.class = '';
                if (!button.type)
                    button.type = 'button';
                if (!button.id)
                    button.id = '';
                if (!button.extra)
                    button.extra = '';

                else if (button.type == 'link')
                    buttons += '<a id="' + button.id + '"' + button.extra + ' href="' + button.link + '" class="btn ' + button.class + '">' + button.text + '</a>';
                else
                    buttons += '<button id="' + button.id + '"' + button.extra + ' type="' + button.type + '" class="btn ' + button.class + '">' + button.text + '</button>';
            })
        }
        if (el.links && el.links.length > 0) {
            el.links.forEach(link => {
                if (!link.class)
                    link.class = '';
                if (!link.id)
                    link.id = '';
                if (!link.extra)
                    link.extra = '';

                links += '<a id="' + link.id + '"' + link.extra + ' href="' + link.link + '" class="btn ' + link.class + '">' + link.text + '</a>';
            })
        }
        if (el.type == 'image') {
            card +=
                cardHead +
                badges +
                Topimage +
                '</div>';
        } else {
            if (!Leftimage && !Rightimage) {
                if (el.type == 'carousel') {
                    card +=
                        cardHead +
                        '<div class="carousel ' + el.imagewrapper + '">' +
                        Topimage +
                        '</div>' +
                        '<div class="card-body">'
                        < 'h5 class="card-title' + el.titleClass + '">' + el.title + '</h5>' +
                        '<h6 class="card-subtitle mb-2 ' + el.subtitleClass + '">' + el.subtitle + '</h6>' +
                        '<p class="card-text ' + el.textClass + '">' + el.text + '</p>' +
                        '<div style="margin: -6rem 0 0 0;" class="slick-navs-dots slider-nav text-center">' +
                        links +
                        '</div>' +
                        buttons +
                        Bottomimage +
                        '</div>' +
                        foots +
                        '</div>';
                } else {
                    card +=
                        cardHead +
                        badges +
                        Topimage +
                        '<div class="card-body">' +
                        '<h5 class="card-title ' + el.titleClass + '">' + el.title + '</h5>' +
                        '<h6 class="card-subtitle mb-2 ' + el.subtitleClass + '">' + el.subtitle + '</h6>' +
                        '<p class="card-text ' + el.textClass + '">' + el.text + '</p>' +
                        links +
                        buttons +
                        Bottomimage +
                        '</div>'
                    foots +
                        '</div>';
                }
            } else {
                card +=
                    cardHead +
                    '<div class="card-body">' +
                    '<div style="display: flex">' +
                    Leftimage +
                    '<div style="margin-left: 2%">' +
                    '<h5 class="card-title">' + el.title + '</h5>' +
                    '<h6 class="card-subtitle mb-2">' + el.subtitle + '</h6>' +
                    '<p class="card-text">' + el.text + '</p>' +
                    '</div>' +
                    Rightimage +
                    '</div>' +
                    links +
                    buttons +
                    '</div>' +
                    foots +
                    '</div>';
            }

        }
        return card;
    }

    this.generateInput = function (el) {
        var id = !el.id ? el.name : el.id;
        var placeholder = el.placeholder ? el.placeholder : "";
        var khusus = ['hidden', 'file', 'select'];
        var params = ['label', 'fgClass', 'attr', 'value', 'labelClass', 'class'];

        params.forEach(item => {
            if (!el[item])
                el[item] = ''
        });

        if (el.type == 'file') {
            return '<div class="input-group col-sm-7 ' + el.fgClass + '">' +
                '<span class="input-group-btn">' +
                '<span class="btn btn-default btn-file">' +
                'Browse… <input type="' + el.type + '" name="' + el.name + '" id="' + id + '">' +
                '</span>' +
                '</span>' +
                '<input type="text" value="' + el.value + '" class="form-control ' + el.class + '" readonly>' +
                '</div>';
        }
        if (el.type == 'hidden')
            return '<input type="hidden" value="' + el.value + '" id="' + id + '" name = "' + el.name + '" />';
        if (el.type == 'textarea')
            return '<div class = "form-group"><label class= "control-label ' + el.labelClass + '" for = "' + id + '">' + el.label + '</label> <textarea name = "' + el.name + '" id = "' + id + '" class = "form-control ' + el.class + '" ' + el.attr + ' placeholder = "' + placeholder + '">' + el.value + '</textarea></div>';

        if (!khusus.includes(el.type))
            return '<div class = "form-group">  <label class= "control-label' + el.labelClass + '" for = "' + id + '">' + el.label + '</label> <input name = "' + el.name + '" type = "' + el.type + '" id = "' + id + '" value = "' + el.value + '" class = "form-control ' + el.class + '"' + el.attr + ' placeholder = "' + placeholder + '"> </div>';
    }

    this.generateModal = function (modalId, wrapper, opt) {
        var body = "";
        var foot = "";
        var stored = null;
        var kembalian = null;
        if (!opt.type)
            opt.type = "nonForm";
        if (!modalId) {
            alert("Id Modal harus di isi!");
            return;
        }
        if (!opt) {
            alert("Opt harus di isi!");
            return;
        }

        if (!opt.modalTitle)
            opt.modalTitle = "";

        if (!opt.modalSubtitle)
            opt.modalSubtitle = "";

        if (opt.modalBody)
            body += this.tambahkanBody(opt.type, opt);

        if (opt.modalFooter) {
            opt.modalFooter.forEach(el => {
                var id = !el.id ? "" : el.id;
                var data = el.data ? el.data : "";
                foot += '<button ' + data + ' type = "' + el.type + '" id ="' + id + '" class ="' + el.class + '">' + el.text + '</button>';
            });
        }

        if (!opt.modalPos)
            opt.modalPos = 'def';

        var modalTemplate = opt.modalPos == 'def' ?
            '<div class="modal fade" id="' + modalId + '" tabindex="-1" role="dialog">' +
            '<div class="modal-dialog ' + opt.size + '" role="document">' +
            '<div class="modal-content">' +
            '<div class="modal-header d-block">' +
            '<div class = "d-flex">' +
            '<h5 class="modal-title">' + opt.modalTitle + '</h5>' +
            '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
            '<span aria-hidden="true">&times;</span>' +
            '</button>' +
            '</div>' +
            '<h6 id="modal-subtitle" class = "modal-title text-muted">' + opt.modalSubtitle + '</h6>' +
            '</div>' +
            '<div class="modal-body">' + body + '</div>' +
            '<div class="modal-footer">' + foot + '</div>' +
            '</div>' +
            '</div>' +
            '</div>'
            :
            opt.modalPos == 'left' ?
                '<div class="modal fade modal-lef" id="' + modalId + '" tabindex="-1" role="dialog">' +
                '<div class="modal-dialog ' + opt.size + '" role="document">' +
                '<div class="modal-content">' +
                '<div class="modal-header d-block">' +
                '<div class = "d-flex">' +
                '<h5 class="modal-title">' + opt.modalTitle + '</h5>' +
                '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span>' +
                '</button>' +
                '</div>' +
                '<h6 id="modal-subtitle" class = "modal-title text-muted">' + opt.modalSubtitle + '</h6>' +
                '</div>' +
                '<div class="modal-body">' + body + '</div>' +
                '<div class="modal-footer">' + foot + '</div>' +
                '</div>' +
                '</div>' +
                '</div>'
                :
                '<div class="modal fade modal-right" id="' + modalId + '" tabindex="-1" role="dialog">' +
                '<div class="modal-dialog ' + opt.size + '" role="document">' +
                '<div class="modal-content">' +
                '<div class="modal-header d-block">' +
                '<div class = "d-flex">' +
                '<h5 class="modal-title">' + opt.modalTitle + '</h5>' +
                '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span>' +
                '</button>' +
                '</div>' +
                '<h6 id="modal-subtitle" class = "modal-title text-muted">' + opt.modalSubtitle + '</h6>' +
                '</div>' +
                '<div class="modal-body">' + body + '</div>' +
                '<div class="modal-footer">' + foot + '</div>' +
                '</div>' +
                '</div>' +
                '</div>'
            ;

        if (opt.open)
            opt.tulis = true;
        if (!wrapper)
            opt.tulis = false;
        if (!opt.ajax)
            opt.ajax = false;

        if (opt.tulis)
            $(wrapper).append(modalTemplate);

        if (opt.open)
            $("#" + modalId).modal('show');

        if (opt.destroy) {
            $("#" + modalId).on('hidden.bs.modal', (e) => {
                e.preventDefault();
                $("#" + e.target.id).remove();
                if (this.instance.validator[modalId.replaceAll('-', '_')]) {
                    this.instance.validator[modalId.replaceAll('-', '_')].destroy();
                    delete (this.instance.validator[modalId.replaceAll('-', '_')]);
                }

            });
        }
        if (opt.type == 'form') {
            stored = { key: modalId, modal: modalTemplate, modalid: modalId, formid: opt.formOpt.formId },
                kembalian = { 'modalId': modalId, 'formId': opt.formOpt.formId, 'modal': modalTemplate }
            if (opt.ajax) {
                var ajaxSubmit = (formId = null) => {
                    var formid = !formId ? opt.formOpt.formId : formId;
                    var succes = opt.submitSuccess ? opt.submitSuccess : () => { };
                    var fail = opt.submitFail ? opt.submitFail : () => { };
                    var sebelumSubmit = opt.sebelumSubmit ? opt.sebelumSubmit : () => { };
                    var rules = {};
                    var options = {
                        success: succes,
                        beforeSubmit: sebelumSubmit
                    };
                    if (opt.rules) {
                        opt.rules.forEach(rule => {
                            jQuery.validator.addMethod(rule.name, rule.method, rule.message);
                            rules[rule.field] = {};
                            rules[rule.field][rule.name] = true;

                        })
                    }
                    this.instance.validator[modalId.replaceAll('-', '_')] = $("#" + formid).validate({
                        rules: rules,
                        submitHandler: function (form) {
                            $('#' + formid + ' #alert_danger, #alert_success').html('').hide();
                            $(form).ajaxSubmit(options);
                        }
                    });
                }
                this.storeAjaxSubmit({ key: opt.formOpt.formId, callback: ajaxSubmit });
                ajaxSubmit();
            }
        } else {
            stored = { key: modalId, modal: modalTemplate, modalid: modalId };
            kembalian = { 'modalId': modalId, 'modal': modalTemplate }
        }

        if (opt.eventListener) {
            $("#" + modalId).on('shown.bs.modal', function () {
                opt.eventListener.forEach(ev => {
                    $(ev.element).on(ev.type, ev.callback);
                })
            });
        }
        $("#" + modalId).on('hidden.bs.modal', opt.saatTutup);
        $("#" + modalId).on('shown.bs.modal', opt.saatBuka);



        this.storeModal(stored);

        if (opt.kembali)
            return kembalian;

    }
    this.initDatatable = function (el, opt) {
        $(el).DataTable({
            searching: !opt.search ? false : opt.search,
            lengthchange: !opt.change ? false : opt.change,
            destroy: true,
            info: !opt.info ? false : opt.info,
            ordering: !opt.order ? false : opt.order,
            sDom:
                '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>',
            pageLength: 6,
            language: {
                paginate: {
                    previous: "<i class='simple-icon-arrow-left'></i>",
                    next: "<i class='simple-icon-arrow-right'></i>"
                }
            },

            drawCallback: function () {
                $($(".dataTables_wrapper .pagination li:first-of-type"))
                    .find("a")
                    .addClass("prev");
                $($(".dataTables_wrapper .pagination li:last-of-type"))
                    .find("a")
                    .addClass("next");

                $(".dataTables_wrapper .pagination").addClass("pagination-sm");
            }
        });
    }
    this.makeNotify = function (opt) {
        const params = [
            'dismiss', 'timpa', 'atasbawah', 'kirikanan', 'append', 'saatmembuka',
            'saatterbuka', 'saatmenutup', 'saattertutup', 'progressBar'
        ];

        params.forEach(item => {
            if (!opt.params)
                opt[params] = '';
        })
        $.notify(
            {
                title: opt.title ? opt.title : "Bootstrap Notify",
                message: opt.message ? opt.message : "Here is a notification!",
                target: "_blank"
            },
            {
                element: opt.append ? opt.append : 'body',
                position: null,
                type: opt.type ? opt.type : 'success',
                allow_dismiss: opt.dismiss ? opt.dismiss : true,
                newest_on_top: opt.timpa ? opt.timpa : true,
                showProgressbar: opt.progressBar ? opt.progressBar : false,
                placement: {
                    from: opt.atasbawah,
                    align: opt.kirikanan
                },
                offset: 20,
                spacing: 10,
                z_index: 1031,
                delay: opt.delay ? opt.delay : 5000,
                timer: 2000,
                url_target: "_blank",
                mouse_over: null,
                animate: {
                    enter: "animated fadeInDown",
                    exit: "animated fadeOutUp"
                },
                onShow: opt.saatmembuka ? opt.saatmembuka : null,
                onShown: opt.saatterbuka ? opt.saatterbuka : null,
                onClose: opt.saatmenutup ? opt.saatmenutup : null,
                onClosed: opt.saattertutup ? opt.saattertutup : null,
                icon_type: "class",
                template:
                    '<div data-notify="container" class="col-11 col-sm-3 alert  alert-{0} " role="alert">' +
                    '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                    '<span data-notify="icon"></span> ' +
                    '<span data-notify="title">{1}</span> ' +
                    '<span data-notify="message">{2}</span>' +
                    '<div class="progress" data-notify="progressbar">' +
                    '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                    "</div>" +
                    '<a href="{3}" target="{4}" data-notify="url"></a>' +
                    "</div>"
            }
        );
    }
    this.generateForm = function (form, input, buttons = null, cards = null) {
        var inputEl = '';
        var buttonsEl = '';
        var formEl = '';
        if (!form.formId)
            form.formId = 'noId'
        if (!form.enctype)
            form.enctype = '';
        if (!form.formMethod)
            form.formMethod = "POST";
        if (!form.formAttr)
            form.formAttr = '';
        if (!form.formClass)
            form.formClass = '';
        input.forEach(element => {
            if (element.type == 'select')
                inputEl += this.generateSelect(element);
            else if (element.type == 'custom')
                inputEl += element.text;
            else
                inputEl += this.generateInput(element);
        });

        if (buttons) {
            buttons.forEach(el => {
                var id = !el.id ? "" : el.id;
                var data = el.data ? el.data : "";
                buttonsEl += '<button style=" margin: 0 10px;"' + data + ' type = "' + el.type + '" id = "' + id + '" class = "' + el.class + '">' + el.text + '</button>';
            });
        }
        formEl +=
            '<form enctype = "' + form.enctype + '" ' + form.formAttr + ' class="' + form.formClass + '" id ="' + form.formId + '" method = "' + form.formMethod + '" action = "' + form.formAct + '">' +
            '<div id="alert_danger" style="display: none" class="alert alert-danger" role="alert"> </div>' +
            '<div id="alert_success" style="display: none" class="alert alert-success" role="alert"> </div>' +
            inputEl +
            buttonsEl +
            '</form>';
        
        $(form.wrapper).append(formEl);

        if (form.ajax) {
            var ajaxSubmit = function (formId = null){
                console.log(formId);
                var formid = !formId ? form.formId : formId;
                var succes = form.submitSuccess ? form.submitSuccess : () => { };
                var fail = form.submitFail ? form.submitFail : () => { };
                var sebelumSubmit = form.sebelumSubmit ? form.sebelumSubmit : () => { };
                var rules = {};
                var options = {
                    success: succes,
                    beforeSubmit: sebelumSubmit
                };
                if (form.rules) {
                    form.rules.forEach(rule => {
                        jQuery.validator.addMethod(rule.name, rule.method, rule.message);
                        rules[rule.field] = {};
                        rules[rule.field][rule.name] = true;

                    })
                }
                this.instance.validator[formid.replaceAll('-', '_')] = $("#" + formid).validate({
                    rules: rules,
                    submitHandler: function (form) {
                        $('#' + formid + ' #alert_danger, #alert_success').html('').hide();
                        $(form).ajaxSubmit(options);
                    }
                });
            }
            this.storeAjaxSubmit({ key: form.formId, callback: ajaxSubmit });
            ajaxSubmit();
        }
    }
}
