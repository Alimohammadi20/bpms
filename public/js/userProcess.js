
$(document).ready(function () {
    initRemoveTableEvent();
    initRemoveEventGroupList();
    initRemoveTableEvent();
    initInputEvents();
    initUploader()
    initAddRowTable()
    initAddRowList()
    initSubmitBtnHandle()
    preview();
    downloadFile();
    // downloadFileAfterLoad();
    // initSelect()
    $('#preload').fadeOut(2000);
});

function initSelect() {
    $('.select2Component').select2({
        placeholder: 'انتخاب کنید',
        allowClear: true,
    });
}

function initCheckBoxAccept() {
    $("input[name^='Accept']").on('change', function (e) {
        if (!e.target.checked) {
            let elm = e.target.name.replace('Accept', 'RejectionReason')
            console.log(elm)
        }
    })
}


function initDatePicker() {
    function requiredCheck(el) {
        el.removeClass('error-msg-input')
        $(`[required-ref="${el.attr('name')}"]`).remove()
    }

    function checkAndCorrect(jDate) {

        let selectedDateArr = jDate.split('/');
        if (selectedDateArr.length == 3) {
            if (parseInt(selectedDateArr[1]) < 10) {
                selectedDateArr[1] = '0' + selectedDateArr[1]
            }
            if (parseInt(selectedDateArr[2]) < 10) {
                selectedDateArr[2] = '0' + selectedDateArr[2]
            }
        }
        return `${selectedDateArr[0]}/${selectedDateArr[1]}/${selectedDateArr[2]}`;
    }

    function format(el, jDate) {
        date = checkAndCorrect(jDate);
        el.attr('data-jdate', date);
        el.val(date);
    }

    let currentDate = new Date().toLocaleDateString('fa-IR');
    currentDate = toEnglishNumber(currentDate);
    let splitedDate = currentDate.split('/');
    let year = splitedDate[0], month = splitedDate[1], day = splitedDate[2];
    $(".pdpDefault").persianDatepicker({
        theme: "latoja",
        close: true,
        alwaysShow: true,
        autoClose: true,
        cellWidth: 25, // by px
        cellHeight: 20, // by px
        fontSize: 13, // by px
        onSelect: function (el, jDate, gDate, showGdate) {
            format(el, jDate)
            validateFormatDate(el)
            requiredCheck(el);
        }
    })
    $(".pdpBirthday").persianDatepicker({
        theme: "latoja",
        close: true,
        alwaysShow: true,
        autoClose: true,
        startDate: currentDate.replace(year, (year - 70).toString()),
        endDate: currentDate.replace(year, (year - 18).toString()),
        cellWidth: 25, // by px
        cellHeight: 20, // by px
        fontSize: 13, // by px
        onSelect: function (el, jDate, gDate, showGdate) {
            format(el, jDate)
            validateFormatDate(el);
            requiredCheck(el);
        }

    })
    $(".pdpFromDate").persianDatepicker({
        theme: "latoja",
        close: true,
        alwaysShow: true,
        autoClose: true,
        startDate: `${year}/${month - 3}/1`,
        endDate: `${year}/${month - 2}/0`,
        cellWidth: 25, // by px
        cellHeight: 20, // by px
        fontSize: 13, // by px
        onSelect: function (el, jDate, gDate, showGdate) {
            format(el, jDate)
            validateFormatDate(el)
            requiredCheck(el);
            let ToDateName = el.attr('name').replace('FromDate', 'ToDate');
            $(`[name="${ToDateName}"]`).val(checkAndCorrect(currentDate))
        }
    })
    $(".pdp-latoja").hide();

    $(document).click(function (event) {
        var $target = $(event.target);
        if (!$target.closest('.pdp-latoja,.pdpDefault,.pdpBirthday,.pdpFromDate,pdp-header,.monthSelect,.yearSelect,.nextArrow,.prevArrow').length) {
            $(".pdp-latoja").hide();
        }
    });
    $('.pdpFromDate').on('keyup', function () {
        let regex = new RegExp($(this).attr('regex'));
        let ToDateName = $(this).attr('name').replace('FromDate', 'ToDate');
        if (regex.test($(this).val())) {
            $(`[name="${ToDateName}"]`).val(checkAndCorrect(currentDate))
        } else {
            $(`[name="${ToDateName}"]`).val('')
        }

    })

    function validateFormatDate(el) {
        $(`[regex-ref="${el.attr('name')}"]`).remove();
    }
}

function initMoney() {
    $('.money-input').on('keyup', function (e) {
        let value = toEnglishNumber(e.target.value)
        e.target.value = insertrialcamma(toFarsiNumber(value))
    });
}

function initLong() {
    $('.long-input').on('keyup', function (e) {
        let value = toEnglishNumber(e.target.value)
        e.target.value = toFarsiNumber(value)
    });
}

async function initUploader() {
    $('.fileInput').on('click', function (e) {
        if ($(this).attr('readonly') === 'readonly') {
            e.preventDefault();
        }
    })
    $('.fileInput').change(async function () {
        let numfiles = $(this)[0].files.length;
        let parent = $(this).closest('.input-file').parent().parent();
        console.log(parent.find('.preview-box'));
        parent.find('.preview-box').remove();
        let fileBase64 = await toBase64($(this)[0].files[0]);
        let random = Math.random();
        if ($(this)[0].files[0].type == 'application/pdf'){
            elm = `<br><img class="preview-box img-fluid" id="${random}" style="height: 60px;" src="/icons/PDF_file_icon.svg.png">`
        }else{
            elm = `<br><img class="preview-box img-fluid" id="${random}" style="width: 250px;" src="${fileBase64}">`
        }
        $(this).attr('image-id', random)
        parent.find('.preview-box').remove()
        parent.find('br').remove();
        parent.find('ins').remove();
        parent = parent.find('.col-md-8');
        for (let i = 0; i < numfiles; i++) {
            parent.append(elm)
            parent.append('<ins><i class="fa-solid fa-check text-success px-2"></i>' + $(this)[0].files[i].name + '</ins>')
        }
    });
}

function initRemoveTableEvent() {
    $('.btn-remove').on('click', removeTableRow)
}

function removeTableRow(e) {
    e.preventDefault();
    let idElm = $(this).data('id');
    $(`#${idElm}`).fadeOut(500, function () {
        $(this).remove();
    });
}

function initRemoveEventGroupList() {
    $('.btn-list-remove').on('click', removeGroupListRow)
}

function removeGroupListRow(e) {
    e.preventDefault();
    let idElm = $(this).data('id');
    $(`#${idElm}`).fadeOut(300, function () {
        $(this).remove();
    });
}

function initInputEvents() {
    initMoney();
    // initLong();
    // initDatePicker()
    initUploader()
    checkValidateOnChange()
    initCheckBoxAccept();
}

function checkValidateOnChange() {
    $("input,select,textarea").on("keyup", validateRealTime)
    $("input,select").on("change", validateRealTime)
    $("input[type='file']").on("change", function () {
        if (this.files.length !== 0) {
            if (this.files[0].size > 10000000) {
                $(this).after(`
          <small id="emailHelp py-2" class="error-div" required-ref="${$(this).attr('name')}">
            <div class="error-msg">حداکثر حجم مجاز برای اپلود 1 مگابایت (1000 کیلوبایت)</div>
        </small>
        `);
                $(this).val('');
            } else {
                $(`[required-ref="${$(this).attr('name')}"]`).remove()
            }
        }
    });
}

function validateRealTime() {
    $(".pdp-latoja").hide();
    if ($(this).val() !== '') {
        $(this).removeClass('error-msg-input')
        $(`[required-ref="${$(this).attr('name')}"]`).remove()
        if ($(this).attr('regex')) {
            let regex = new RegExp($(this).attr('regex'));
            if (regex.test($(this).val())) {
                $(this).removeClass('error-msg-input')
                $(`[regex-ref="${$(this).attr('name')}"]`).remove()
            } else {
                if ($(`[regex-ref="${$(this).attr('name')}"]`).length === 0) {
                    $(this).addClass("error-msg-input");
                    $(this).after(`
                        <small id="emailHelp py-2" class="error-div" regex-ref="${$(this).attr('name')}">
                           <div class="error-msg">* فرمت  ${$(this).attr('placeholder').replaceAll('*', '')} معتبر نیست </div>
                        </small>
                          `);
                }
            }
        }
        if ($(this).attr('min') !== undefined) {
            if (parseInt($(this).attr('min')) <= parseInt($(this).val())) {
                $(this).removeClass('error-msg-input')
                $(`[min-ref="${$(this).attr('name')}"]`).remove()
            } else {
                if ($(`[min-ref="${$(this).attr('name')}"]`).length === 0) {
                    $(this).addClass("error-msg-input");
                    $(this).after(`
                        <small id="emailHelp py-2" class="error-div" min-ref="${$(this).attr('name')}">
                           <div class="error-msg">* حداقل مقدار قابل قبول ${$(this).attr('min')} میباشد</div>
                        </small>
                          `);
                }
            }
        }
        if ($(this).attr('max') !== undefined) {
            if (parseInt($(this).attr('max')) >= parseInt($(this).val())) {
                $(this).removeClass('error-msg-input')
                $(`[max-ref="${$(this).attr('name')}"]`).remove()
            } else {
                $(this).val($(this).attr('max'))
                if ($(`[max-ref="${$(this).attr('name')}"]`).length === 0) {
                    $(this).addClass("error-msg-input");
                    $(this).after(`
                        <small id="emailHelp py-2" class="error-div" max-ref="${$(this).attr('name')}">
                           <div class="error-msg">* حداکثر مقدار قابل قبول ${$(this).attr('max')} میباشد</div>
                        </small>
                          `);
                }
            }
        }
        if ($(this).attr('type') === 'number') {
            $(this).val(parseInt($(this).val()))
        }

    } else {
        $(`[max-ref="${$(this).attr('name')}"]`).remove();
        $(`[min-ref="${$(this).attr('name')}"]`).remove();
        $(`[regex-ref="${$(this).attr('name')}"]`).remove()
        if ($(this).attr('required') !== undefined && $(`[required-ref="${$(this).attr('name')}"]`).length === 0) {
            $(this).addClass("error-msg-input");
            $(this).after(`
          <small id="emailHelp py-2" class="error-div" required-ref="${$(this).attr('name')}">
            <div class="error-msg">* فیلد  ${($(this).attr('placeholder')) ? $(this).attr('placeholder').replaceAll('*', '') : ''}   الزامیست </div>
        </small>
        `);
        }
    }
}

function initAddRowTable() {
    $('.add-row-btn').on('click', function (e) {
        let index = Number($('#lastRowTable').val()) + 1;
        let id = e.target.dataset.tableId;
        $(`#${id}-display`).removeClass('d-none')
        $('#lastRowTable').val(index)
        let elm = '#tr-add-new-' + id;
        let pattern = $(elm).html()
        pattern = pattern.replaceAll("@index", index)
        pattern = `<tr id="row-btn-${index}">
                <td style="min-width: 70px;"><a class="btn-remove" data-id="row-btn-${index}"> <img
                            src="${deleteImg}" alt=""> </a></td>
                ${pattern}</tr>`
        pattern = pattern.replaceAll('error-msg-input', '')
        $(`#row-${id}`).append(pattern);
        initRemoveTableEvent();
        initUploader();
        initInputEvents();

    });
}

function initAddRowList() {
    $('.add-list-btn').on('click', function (e) {
        let index = Number($('#lastRowGroupField').val()) + 1;
        let id = e.target.dataset.listId;
        let comboBox = `#comboBox-${id}`;
        let comboBoxVal = $(comboBox).val();
        if (comboBoxVal !== '') {
            if ($('#choose-option-msg').css('display') != 'none') {
                $('#choose-option-msg').toggle()
            }
            let pattern = $(`#${comboBoxVal}`).html()
            pattern = `<div id="row-list-${index}">${pattern}</div>`
            pattern = String(pattern).replace('@id', `row-list-${index}`)
            pattern = pattern.replaceAll("@index", index)
            pattern = pattern.replaceAll('error-msg-input', '')
            $(`#user-${id}`).append(pattern);
            $('#lastRowGroupField').val(index);
            initRemoveEventGroupList();
            initInputEvents();
        } else {
            if ($('#choose-option-msg').css('display') == 'none') {
                $('#choose-option-msg').toggle()
            }
        }

    });
}

function initSubmitBtnHandle() {
    $('[name="submit_btn"]').on('click', function (e) {
        e.preventDefault();
        if (e.target.value == 'cancel') {
            Swal.fire({
                title: "کاربر گرامی",
                text: "آیا از ادامه فرایند خود انصراف می دهید؟",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: 'بله',
                cancelButtonText: 'خیر',
                dangerMode: true,
            }).then(function (isConfirm) {
                if (isConfirm.isConfirmed) {
                    validateAndSubmit(e)
                }
            })
        } else {
            validateAndSubmit(e)
        }

    });
}

function validateAndSubmit(e) {
    if ((checkValidate() && e.target.value == 'next') || e.target.value != 'next') {
        $('#preload').fadeIn();
        $('#hidden_submit').val(e.target.value)
        let templates = $('[template-ref="temlpate"]')
        for (const element of templates) {
            element.remove()
        }
        $("#processForm").submit();
    }
}

function checkValidate() {
    let validate = true;
    $('.error-msg-input').each(function () {
        $(this).removeClass('error-msg-input')
    })
    $('.error-div').each(function () {
        $(this).remove()
    })
    $("[required]").each(function () {
        if ($(this).attr('type') === 'file') {
            if (this.files.length === 0 && !$(this).attr('name').includes('@index')) {
                validate = false;
                $(this).addClass("error-msg-input");
                $(this).after(`
          <small id="emailHelp py-2" class="error-div" required-ref="${$(this).attr('name')}">
            <div class="error-msg">* این فیلد الزامیست</div>
        </small>
        `);
            }
        } else {
            if ($(this).val() === "" && !$(this).attr('name').includes('@index')) {
                validate = false;
                $(this).addClass("error-msg-input");
                $(this).after(`
          <small id="emailHelp py-2" class="error-div" required-ref="${$(this).attr('name')}">
            <div class="error-msg">* فیلد  ${($(this).attr('placeholder')) ? $(this).attr('placeholder').replaceAll('*', '') : ''}   الزامیست </div>
        </small>
        `);
            }
        }

    });
    if (validate) {
        $('[regex]').each(function () {
            let regex = new RegExp($(this).attr('regex'));
            if (!regex.test($(this).val()) && !$(this).attr('name').includes('@index')) {
                validate = false;
                $(this).addClass("error-msg-input");
                $(this).after(`
          <small id="emailHelp py-2" class="error-div" regex-ref="${$(this).attr('name')}">
            <div class="error-msg">* فرمت  ${$(this).attr('placeholder').replaceAll('*', '')} معتبر نیست </div>
        </small>
        `);
            }
        });
    }
    return validate;
}

function preview() {
    $('.preview-btn').on('click', function (e) {
        e.preventDefault();
        let elmID = `#${e.target.dataset.refPreview}`;
        if ($(elmID).attr('controls')) {
            $(`${elmID} source`).attr('src', e.target.dataset.src);
            $(elmID)[0].load();
        } else {
            $(elmID).attr('src', e.target.dataset.src);
            $(elmID).attr('src', e.target.dataset.src);
        }
        $(elmID).fadeToggle();
    })
}

function downloadFile() {
    $('.downlaod-btn').on('click', function (e) {
        let thisElm = $(this);
        e.preventDefault();
        let href = $(this).attr('href')
        $.ajax(
            {
                url: href,
                success: function (result) {
                    console.log(result)
                    if (result.status) {
                        let link = document.createElement('a');
                        link.setAttribute('href', result.downloadLink);
                        link.setAttribute('target', '_blank');
                        link.setAttribute('download', result.fileName); // Need to modify filename ...
                        link.click();
                        let elm = '';
                        if (!result.fileName.includes('pdf') && thisElm.attr('download-before') !== 'true') {
                            if (result.fileName.includes('mp4') || result.fileName.includes('webm')) {
                                let ex = result.fileName.split('.')
                                elm = `<video class="preview-box" controls style="width: 100%;height: 250px;">
                                        <source type="video/${ex[1]}" src="${result.link}">
                                        مرورگر شما ساپورت نمیکند
                                    </video>`
                            }
                            thisElm.attr('download-before', true)

                        }
                    } else {
                        Swal.fire("کاربرگرامی", "فایل وجود ندارد!", "info");
                    }
                }
            })
    })
}
function downloadFileAfterLoad() {
    window.onload = function () {
        let thisElms = $('.downlaod-btn');
        for (let i = 0; i < thisElms.length; i++) {
            let thisElm = $(thisElms[i]);
            // let type = thisElm.getAttribute('type') || 'submit'; // Submit is the default
            let href = thisElm.attr('href')
            let btnAttr = thisElm.attr('download-before')

            $.ajax(
                {
                    url: href,
                    success: function (result) {

                        // if (result.status && !result.fileName.includes('mp4') && !result.fileName.includes('webm')) {
                            let elm = '<div class="text-center">';
                            if (result.fileName.includes('mp4') || result.fileName.includes('webm')) {
                                let ex = result.fileName.split('.')
                                elm += `<br><video class="preview-box plyr__video-embed" controls style="width: 500px;height: 250px;">
                                        <source type="video/${ex[1]}" src="${result.link}">
                                        مرورگر شما ساپورت نمیکند
                                    </video>`
                            } else if(result.fileName.includes('pdf')){
                                elm += `<br><a href="${result.link}" target="_blank"><img class="preview-box img-fluid lozad" style="height: 180px;" data-src="/PDF_file_icon.svg.png"></a>`;
                            }else {
                                elm += `<br><a href="${result.link}" target="_blank"><img class="preview-box img-fluid lozad" style="height: 180px;" data-src="${result.link}"></a>`;
                            }
                        elm += '</div>'
                            thisElm.attr('download-before', true)
                            thisElm.parent().append(elm)
                        }

                    // }

                })
            // ...
        }

        // e.preventDefault();


    }
}

const toBase64 = file => new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => resolve(reader.result);
    reader.onerror = error => reject(error);
});


(function () {

    // ! Documentation Tour only
    const startBtnDocs = document.querySelector('#task-form-tour');

    function setupTourDocs(tour) {
        const backBtnClass = 'btn btn-sm btn-label-secondary md-btn-flat',
            nextBtnClass = 'btn btn-sm btn-primary btn-next';
        tour.addStep({
            title: 'مدیریت تسک',
            text: 'در این بخش شما می توانید اطلاعات درخواست دهنده و تسک های آن را ببینید.',

            buttons: [
                {
                    action: tour.cancel,
                    classes: backBtnClass,
                    text: 'رد کردن'
                },
                {
                    text: 'شروع آموزش',
                    classes: nextBtnClass,
                    action: tour.next
                }
            ]
        });
        tour.addStep({
            title: 'بخش اقلام اطلاعاتی',
            text: 'در این بخش شما می توانید خلاصه ای از اطلاعات درخواست دهنده را ببینید در آخر وضعیت درخواست او را مشخص کنید.',
            attachTo: {element: '.nav-pill-1', on: 'bottom'},
            buttons: [
                {
                    action: tour.cancel,
                    classes: backBtnClass,
                    text: 'رد کردن'
                },
                {
                    text: 'قبلی',
                    classes: nextBtnClass,
                    action: tour.back
                },
                {
                    text: 'بعدی',
                    classes: nextBtnClass,
                    action: tour.next
                }
            ]
        });
        tour.addStep({
            title: 'بخش جداول اطلاعاتی',
            text: 'در این بخش شما می توانید اطلاعات شغلی کاربر، ضامنین، اطلاعات حساب بانکی و چک ها را بررسی کنید.',
            attachTo: {element: '.nav-pill-2', on: 'bottom'},
            buttons: [
                {
                    action: tour.cancel,
                    classes: backBtnClass,
                    text: 'رد کردن'
                },
                {
                    text: 'قبلی',
                    classes: nextBtnClass,
                    action: tour.back
                },
                {
                    text: 'بعدی',
                    classes: nextBtnClass,
                    action: tour.next
                }
            ]
        });
        tour.addStep({
            title: 'بزرگنمایی',
            text: 'برای رفتن به حالت تمام صفحه می توانید روی این دکمه کلیک کنید.',
            attachTo: {element: '.bx-fullscreen', on: 'bottom'},
            buttons: [
                {
                    action: tour.cancel,
                    classes: backBtnClass,
                    text: 'رد کردن'
                },
                {
                    text: 'قبلی',
                    classes: nextBtnClass,
                    action: tour.back
                },
                {
                    text: 'بعدی',
                    classes: nextBtnClass,
                    action: tour.next
                }
            ]
        });
        tour.addStep({
            title: 'فیلدها',
            text: 'این بخش به کمک دکمه ای که در سمت چپ آمده است، می تواند باز یا بسته شود.',
            attachTo: {element: '#card-header-1', on: 'bottom'},
            buttons: [
                {
                    action: tour.cancel,
                    classes: backBtnClass,
                    text: 'رد کردن'
                },
                {
                    text: 'قبلی',
                    classes: nextBtnClass,
                    action: tour.back
                },
                {
                    text: 'بعدی',
                    classes: nextBtnClass,
                    action: tour.next
                }
            ]
        });

        tour.addStep({
            title: 'دکمه باز یا بسته شدن باکس',
            text: 'با کلیک بر روی این دکمه می توانید باکس مورد نظر را ببندید یا باز کنید.',
            attachTo: {element: '#card-action-element-1', on: 'bottom'},
            buttons: [
                {
                    action: tour.cancel,
                    classes: backBtnClass,
                    text: 'رد کردن'
                },
                {
                    text: 'پایان',
                    classes: nextBtnClass,
                    action: tour.cancel
                },

            ]
        });

        return tour;
    }

    if (startBtnDocs) {
        // On start tour button click
        startBtnDocs.onclick = function () {
            const tourDocsVar = new Shepherd.Tour({
                defaultStepOptions: {
                    scrollTo: false,
                    cancelIcon: {
                        enabled: true
                    }
                },
                useModalOverlay: true
            });

            setupTourDocs(tourDocsVar).start();
        };
    }
})();
