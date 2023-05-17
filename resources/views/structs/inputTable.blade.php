@pushOnce('head')
<link href="{{asset('assets/vendor/DataTables3/datatables.css')}}" rel="stylesheet"/>
@endPushOnce
<span class="fa fa-circle-dot" style="color: #0c65e8"></span>
<h6 style="color: black !important;font-weight: bold;display: inline;">{{$table->name}}
    @if($table->rowEditable && false)
        <a data-table-id="table-{{$loop->index}}" class="add-row-btn  m-2">
            <span class="btn" data-table-id="table-{{ $loop->index}}" style="height: 25px">
                <i class="fa-solid fa-plus pb-2" data-table-id="table-{{$loop->index}}"></i>
            </span>
            افزودن
        </a>
    @endif
</h6>
<table
    class="mt-2 {{count((array)$table->value) > 0 || old('table') != null ? "" : "d-none"}} sampletable table table-responsive w-100 d-block"
    id="table-{{$loop->index}}-display1" style="overflow-x:auto;width:100%;overflow-y:hidden;">
    <thead>
    <tr>
        @if($table->rowAddable && false)
            <td style="width: 60px"></td>
        @endif
        @foreach($table->formProperties as $key=>$column)
            @if($column->readable)
                <th {{($column->type != 'id' ? 'style="min-width: 200px"' : '' )}}>{{($column->required) ? " * " : ""}} {{$column->name}}</th>
            @endif
        @endforeach
    </tr>
    </thead>
    <tbody id="row-table-{{$loop->index}}">
    @php
        $lastRowTable =0;
        if (count((array)$table->value) > 0 ){
                $datas = $table->value;
        }
    @endphp
    @foreach($datas as $oldDataKey =>$oldData)
        @php
            $index = isset($oldData->Id) ? $oldData->Id :$oldDataKey+1;
            $lastRowTable= isset($oldData->Id) ? $oldData->Id : $loop->index ;
        @endphp
        <tr id="row-btn-{{$index}}" style="min-width: 70px;">
            @if($table->rowAddable && false)
                <td><a class="btn-remove" data-id="row-btn-{{$index}}"><img
                            src="{{asset('icons/delete(1).svg')}}" alt="delete(1).svg"></a></td>
            @endif
            @foreach($table->formProperties as $propertyKey=>$input)
                @if($input->readable)
                    <td>
                        @switch($input->type)
                            @case('id')
                                @include('services.bpms2.components.Table.input.id',['inputSettings'=>$input,'id'=>$index])
                                @break
                            @case('datePicker')
                                @include('services.bpms2.components.Table.input.datePicker',['isStruct'=>false,'inputSettings'=>$input])
                                @break
                            @case('string')
                                @include('services.bpms2.components.Table.input.txtInput',['inputSettings'=>$input,'isStruct'=>false,'otherClass'=>''])
                                @break
                            @case('boolean')
                                @include('services.bpms2.components.Table.input.checkBox',['inputSettings'=>$input,'isStruct'=>false])
                                @break
                            @case('enum')
                                @include('services.bpms2.components.Table.input.selectBox',['inputSettings'=>$input,'oldData'=>$oldData,'index'=>$index,'key'=>$propertyKey,'isStruct'=>false])
                                @break
                            @case('long')
                                @include('services.bpms2.components.Table.input.txtInput',['inputSettings'=>$input,'otherClass'=>'long-input','isStruct'=>false])
                                @break
                            @case('money')
                                @include('services.bpms2.components.Table.input.txtInput',['inputSettings'=>$input,'otherClass'=>'money-input','isStruct'=>false])
                                @break
                            @case('textarea')
                                @include('services.bpms2.components.Table.input.textArea',['inputSettings'=>$input,'isStruct'=>false])
                                @break
                            @case("file")
                                @include('services.bpms2.components.Table.input.uploadDocument',['inputSettings'=>$input,'isStruct'=>false])
                                @break
                            @case("hyperlink")
                                @include('services.bpms2.components.Table.input.hyperlink',['inputSettings'=>$input,'isStruct'=>false])
                                @break
                            @case('radioBtn')
                                @include('services.bpms2.components.Table.input.radioButt',['inputSettings'=>$input,'isStruct'=>false])
                                @break
                        @endswitch
                    </td>
                @else
                    <input type="hidden" value="{{$propertyKey}}"
                           name="table[{{$table->id}}][{{$index}}][{{$propertyKey}}]">
                @endif
            @endforeach
        </tr>
        @php
            unset($oldData);
        @endphp
    @endforeach
    </tbody>
    <tfoot>
    </tfoot>
</table>
@error("table.{$table->id}")
<p class="error-msg">{{$message}}</p>
@enderror

<table class="d-none" template-ref="temlpate">
    <tr id="tr-add-new-table-{{$loop->index}}">
        @if($table->rowEditable && false)
            @foreach($table->formProperties as $key=>$input)
                {{--                @php--}}
                {{--                    $inputSettings = collect();--}}
                {{--                    $inputSettings->regex = $input->Expression ? "regex={$input->Expression->Regex}" :'' ;--}}
                {{--                    $inputSettings->label = (($input->Required)? ' * ' : '').$input->Name;--}}
                {{--                    $inputSettings->required = ($input->Required)? 'required' : '' ;--}}
                {{--                    $inputSettings->writable = (!$table->writable)? 'readonly="readonly"' : '' ;--}}
                {{--                    $inputSettings->placeholder =isset($input->Placeholder) ? $input->Placeholder : $input->Name;--}}
                {{--                    $inputSettings->hidden =str_contains(strtolower($key), 'hiden') ? "d-none" : '';--}}
                {{--                    if ($input->Type == 'string' && str_starts_with(strtolower($key),"_ymdatetime_")){--}}
                {{--                        $inputSettings->component = "pdpDefault";--}}
                {{--                        $inputSettings->disabled = "";--}}
                {{--                        if (strpos(strtolower($key),'birthdate') > 0){--}}
                {{--                        $inputSettings->component = "pdpBirthday";--}}
                {{--                        }elseif (strpos(strtolower($key),'fromdate')){--}}
                {{--                        $inputSettings->component = "pdpFromDate";--}}
                {{--                        }elseif (strpos(strtolower($key),'todate')){--}}
                {{--                        $inputSettings->component = "pdpToDate";--}}
                {{--                        $inputSettings->disabled ='readonly="readonly"';--}}
                {{--                        }--}}
                {{--                    }--}}
                {{--                    $inputSettings->name =  "table[{$table->id}][@index][{$key}]" ;--}}
                {{--                   switch ($input->Type){--}}
                {{--                        case 'boolean':--}}
                {{--                           $inputSettings->value = old($key) ?(filter_var($input->Value, FILTER_VALIDATE_BOOLEAN)? "checked"  : "") : (filter_var($input->Value, FILTER_VALIDATE_BOOLEAN) ? "checked" :'');--}}
                {{--                            break;--}}
                {{--                        case 'enum':--}}
                {{--                           $inputSettings->value =  old($key) ?  old($key) : $input->Values==$key ;--}}
                {{--                            break;--}}
                {{--                        case 'textarea':--}}
                {{--                           $inputSettings->value = (isset($data) ? $data->{$key} : '' ) . (isset($input->Value))? $input->Value :'';--}}
                {{--                            break;--}}
                {{--                        case 'file':--}}
                {{--                             $inputSettings->value = $inputSettings->downloadable = $inputSettings->hasFile = null;--}}
                {{--                            if($input->File?->downloadable){--}}
                {{--                                 $inputSettings->downloadable = isset($input->File->downloadLink) ? $input->File->downloadLink : route('process.download.file',['filename'=>$input->File->fileName,'variable'=>$key]);--}}
                {{--                            }--}}
                {{--                            if (isset($input->File)){--}}
                {{--                                $inputSettings->hasFile = preparePlatformFile($input->File);--}}
                {{--                            }--}}
                {{--                            break;--}}
                {{--                        default:--}}
                {{--                           $inputSettings->value =old($key) ? (old($key)) : ((isset($input->Value))? ($input->Value) :'') ;--}}
                {{--                        break;--}}

                {{--                    }--}}
                {{--                    $inputSettings->hasError = $errors->has($key) ? "error-msg-input" : "";--}}
                {{--                @endphp--}}
                @if($input->readable)
                    <td>
                        @switch($input->type)
                            @case('string')
                                @if(str_starts_with(strtolower($key),"_ymdatetime_"))
                                    @include('services.bpms2.components.Table.input.datePicker',['isStruct'=>true])
                                @else
                                    @include('services.bpms2.components.Table.input.txtInput',['isStruct'=>true])
                                @endif
                                @break
                            @case('boolean')
                                @include('services.bpms2.components.Table.input.checkBox',['isStruct'=>true])
                                @break
                            @case('enum')
                                @include('services.bpms2.components.Table.input.selectBox',['isStruct'=>true])
                                @break
                            @case('long')
                                @include('services.bpms2.components.Table.input.txtInput',['isStruct'=>true])
                                @break
                            @case('money')
                                @include('services.bpms2.components.Table.input.money',['isStruct'=>true])
                                @break
                            @case('textarea')
                                @include('services.bpms2.components.Table.input.textArea',['isStruct'=>true])
                                @break
                            @case('hyperlink')
                                @include('services.bpms2.components.Table.input.hyperlink',['isStruct'=>true])
                                @break
                            @case("file")
                                @if($key=="_huge_Video")
                                    @include('services.bpms2.components.Table.input.liveVideo',['isStruct'=>true])
                                    {{-- video--}}
                                @elseif($key=="_huge_Document")
                                    @include('services.bpms2.components.Table.input.uploadDocument',['isStruct'=>true])
                                @elseif($key=="_huge_Camera")
                                    {{--open camera--}}
                                    @include('services.bpms2.components.Table.input.liveCamera',['isStruct'=>true])
                                @else
                                    @include('services.bpms2.components.Table.input.uploadDocument',['isStruct'=>true,'index'=>'@index'])
                                @endif
                                @break
                        @endswitch
                        @if(str_split($key,6)[0]=="Accept")
                            @include('services.bpms2.components.Table.input.checkBox',['isStruct'=>true])
                        @elseif(str_starts_with(strtolower($key),'_rd'))
                            @include('services.bpms2.components.Table.input.radioButt',['isStruct'=>true])
                        @endif
                    </td>
                @else
                    <input type="hidden" id="row-1-age" value="@index" name="table[{{$table->id}}][@index][{{$key}}]">
                @endif
            @endforeach
        @endif
    </tr>
</table>
<input type="hidden" name="lastRowTable" id="lastRowTable"
       value="{{old('lastRowTable')?old('lastRowTable') :$lastRowTable}}">
@push('script')
<script src="{{asset('assets/vendor/DataTables3/datatables.js')}}"></script>
    <script>
        const deleteImg = "{{asset('icons/delete(1).svg')}}";
    </script>
<script>
    $(document).ready(function () {
        let faLang = {
            "emptyTable": "هیچ داده‌ای در جدول وجود ندارد",
            "info": "نمایش _START_ تا _END_ از _TOTAL_ ردیف",
            "infoEmpty": "نمایش 0 تا 0 از 0 ردیف",
            "infoFiltered": "(فیلتر شده از _MAX_ ردیف)",
            "infoThousands": ",",
            "lengthMenu": "نمایش _MENU_ ردیف",
            "processing": "در حال پردازش...",
            "search": "جستجو:",
            "zeroRecords": "رکوردی با این مشخصات پیدا نشد",
            "paginate": {
                "next": "بعدی",
                "previous": "قبلی",
                "first": "ابتدا",
                "last": "انتها"
            },
            "aria": {
                "sortAscending": ": فعال سازی نمایش به صورت صعودی",
                "sortDescending": ": فعال سازی نمایش به صورت نزولی"
            },
            "autoFill": {
                "cancel": "انصراف",
                "fill": "پر کردن همه سلول ها با ساختار سیستم",
                "fillHorizontal": "پر کردن سلول به صورت افقی",
                "fillVertical": "پرکردن سلول به صورت عمودی"
            },
            "buttons": {
                "collection": "مجموعه",
                "colvis": "قابلیت نمایش ستون",
                "colvisRestore": "بازنشانی قابلیت نمایش",
                "copy": "کپی",
                "copySuccess": {
                    "1": "یک ردیف داخل حافظه کپی شد",
                    "_": "%ds ردیف داخل حافظه کپی شد"
                },
                "copyTitle": "کپی در حافظه",
                "pageLength": {
                    "-1": "نمایش همه ردیف‌ها",
                    "_": "نمایش %d ردیف",
                    "1": "نمایش 1 ردیف"
                },
                "print": "چاپ",
                "copyKeys": "برای کپی داده جدول در حافظه سیستم کلید های ctrl یا ⌘ + C را فشار دهید",
                "csv": "فایل CSV",
                "pdf": "فایل PDF",
                "renameState": "تغییر نام",
                "updateState": "به روز رسانی",
                "excel": "فایل اکسل",
                "createState": "ایجاد وضعیت جدول",
                "removeAllStates": "حذف همه وضعیت ها",
                "removeState": "حذف",
                "savedStates": "وضعیت های ذخیره شده",
                "stateRestore": "بازگشت به وضعیت %d"
            },
            "searchBuilder": {
                "add": "افزودن شرط",
                "button": {
                    "0": "جستجو ساز",
                    "_": "جستجوساز (%d)"
                },
                "clearAll": "خالی کردن همه",
                "condition": "شرط",
                "conditions": {
                    "date": {
                        "after": "بعد از",
                        "before": "بعد از",
                        "between": "میان",
                        "empty": "خالی",
                        "not": "نباشد",
                        "notBetween": "میان نباشد",
                        "notEmpty": "خالی نباشد",
                        "equals": "برابر باشد با"
                    },
                    "number": {
                        "between": "میان",
                        "empty": "خالی",
                        "gt": "بزرگتر از",
                        "gte": "برابر یا بزرگتر از",
                        "lt": "کمتر از",
                        "lte": "برابر یا کمتر از",
                        "not": "نباشد",
                        "notBetween": "میان نباشد",
                        "notEmpty": "خالی نباشد",
                        "equals": "برابر باشد با"
                    },
                    "string": {
                        "contains": "حاوی",
                        "empty": "خالی",
                        "endsWith": "به پایان می رسد با",
                        "not": "نباشد",
                        "notEmpty": "خالی نباشد",
                        "startsWith": "شروع  شود با",
                        "notContains": "نباشد حاوی",
                        "notEndsWith": "پایان نیابد با",
                        "notStartsWith": "شروع نشود با",
                        "equals": "برابر باشد با"
                    },
                    "array": {
                        "empty": "خالی",
                        "contains": "حاوی",
                        "not": "نباشد",
                        "notEmpty": "خالی نباشد",
                        "without": "بدون",
                        "equals": "برابر باشد با"
                    }
                },
                "data": "اطلاعات",
                "logicAnd": "و",
                "logicOr": "یا",
                "title": {
                    "0": "جستجو ساز",
                    "_": "جستجوساز (%d)"
                },
                "value": "مقدار",
                "deleteTitle": "حذف شرط فیلتر",
                "leftTitle": "شرط بیرونی",
                "rightTitle": "شرط فرورفتگی"
            },
            "select": {
                "cells": {
                    "1": "1 سلول انتخاب شد",
                    "_": "%d سلول انتخاب شد"
                },
                "columns": {
                    "1": "یک ستون انتخاب شد",
                    "_": "%d ستون انتخاب شد"
                },
                "rows": {
                    "1": "1ردیف انتخاب شد",
                    "_": "%d  انتخاب شد"
                }
            },
            "thousands": ",",
            "searchPanes": {
                "clearMessage": "همه را پاک کن",
                "collapse": {
                    "0": "صفحه جستجو",
                    "_": "صفحه جستجو (٪ d)"
                },
                "count": "{total}",
                "countFiltered": "{shown} ({total})",
                "emptyPanes": "صفحه جستجو وجود ندارد",
                "loadMessage": "در حال بارگیری صفحات جستجو ...",
                "title": "فیلترهای فعال - %d",
                "showMessage": "نمایش همه",
                "collapseMessage": "بستن همه"
            },
            "loadingRecords": "در حال بارگذاری...",
            "datetime": {
                "previous": "قبلی",
                "next": "بعدی",
                "hours": "ساعت",
                "minutes": "دقیقه",
                "seconds": "ثانیه",
                "amPm": [
                    "صبح",
                    "عصر"
                ],
                "months": {
                    "0": "ژانویه",
                    "1": "فوریه",
                    "10": "نوامبر",
                    "4": "می",
                    "8": "سپتامبر",
                    "11": "دسامبر",
                    "3": "آوریل",
                    "9": "اکتبر",
                    "7": "اوت",
                    "2": "مارس",
                    "5": "ژوئن",
                    "6": "ژوئیه"
                },
                "unknown": "-",
                "weekdays": [
                    "یکشنبه",
                    "دوشنبه",
                    "سه‌شنبه",
                    "چهارشنبه",
                    "پنجشنبه",
                    "جمعه",
                    "شنبه"
                ]
            },
            "editor": {
                "close": "بستن",
                "create": {
                    "button": "جدید",
                    "title": "ثبت جدید",
                    "submit": "ایجــاد"
                },
                "edit": {
                    "button": "ویرایش",
                    "title": "ویرایش",
                    "submit": "به روز رسانی"
                },
                "remove": {
                    "button": "حذف",
                    "title": "حذف",
                    "submit": "حذف",
                    "confirm": {
                        "_": "آیا از حذف %d خط اطمینان دارید؟",
                        "1": "آیا از حذف یک خط اطمینان دارید؟"
                    }
                },
                "multi": {
                    "restore": "واگرد",
                    "noMulti": "این ورودی را می توان به صورت جداگانه ویرایش کرد، اما نه بخشی از یک گروه",
                    "title": "مقادیر متعدد",
                    "info": "مقادیر متعدد"
                },
                "error": {
                    "system": "خطایی رخ داده (اطلاعات بیشتر)"
                }
            },
            "decimal": ".",
            "stateRestore": {
                "creationModal": {
                    "button": "ایجاد",
                    "columns": {
                        "search": "جستجوی ستون",
                        "visible": "وضعیت نمایش ستون"
                    },
                    "name": "نام:",
                    "order": "مرتب سازی",
                    "paging": "صفحه بندی",
                    "search": "جستجو",
                    "select": "انتخاب",
                    "title": "ایجاد وضعیت جدید",
                    "toggleLabel": "شامل:",
                    "scroller": "موقعیت جدول (اسکرول)",
                    "searchBuilder": "صفحه جستجو"
                },
                "emptyError": "نام نمیتواند خالی باشد.",
                "removeConfirm": "آیا از حذف %s مطمئنید؟",
                "removeJoiner": "و",
                "renameButton": "تغییر نام",
                "renameLabel": "نام جدید برای $s :",
                "duplicateError": "وضعیتی با این نام از پیش ذخیره شده.",
                "emptyStates": "هیچ وضعیتی ذخیره نشده",
                "removeError": "حذف با خطا موماجه شد",
                "removeSubmit": "حذف وضعیت",
                "removeTitle": "حذف وضعیت جدول",
                "renameTitle": "تغییر نام وضعیت"
            }
        };
        // Setup - add a text input to each footer cell

        // DataTable
        $('#table-0-display1').DataTable({
            language: faLang,
            initComplete: function () {
                this.api()
                    .columns([2])
                    .every(function () {
                        var column = this;
                        var select = $('<select class="form-select select2 ms-3" style="width: 250px !important;"><option value="">فیلتر بر اساس عنوان فرآیند</option></select>')
                            .appendTo($('#inbox-table_filter'))
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());

                                column.search(val ? '^' + val + '$' : '', true, false).draw();
                            });

                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                let option = `<option>${d}</option>`
                                select.append(option);
                            });
                    });
            },
        });

        $('#year').on('change', function () {
            let year = $(this).find(":selected").val();
            let url = $(location).attr('href').split('?')[0]
            window.location = url + `?year=${year}`;
        });





    });
</script>


@endpush
