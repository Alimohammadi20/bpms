@pushOnce('head')
<link href="{{asset('assets/vendor/datatables/datatables.min.css')}}" rel="stylesheet"/>
@endPushOnce
<span class="fa fa-circle-dot" style="color: #0c65e8"></span>
<h6 style="color: black !important;font-weight: bold;display: inline;">{{$table->name}}</h6>
<div class="table-responsive" style="overflow-y: hidden !important;">
    <table
        class="mt-2 {{count((array)$table->value) > 0 || old('table') != null ? "" : "d-none"}} data-table table table-striped  table-bordered table-responsive w-100"
        id="table-{{$loop->index}}-display" style="overflow-x:scroll;width:100%;overflow-y:hidden;">
        <thead>
        <tr>
            @foreach($table->formProperties as $key=>$column)
                @if($column->readable)
                    @if($column->type == 'id')
                        <th class="text-center" style="width: 75px">{{($column->required) ? " * " : ""}} {{$column->name}}</th>
                    @else
                        <th class="text-center">{{($column->required) ? " * " : ""}} {{$column->name}}</th>
                    @endif
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
                @foreach($table->formProperties as $propertyKey=>$input)
                    @if($input->readable)
                        <td class="text-center">
                            @switch($input->type)
                                @case('id')
                                @include('services.bpms2.components.Table.data.id',['inputSettings'=>$input,'id'=>$index])
                                @break
                                @case('datePicker')
                                @include('services.bpms2.components.Table.data.datePicker',['isStruct'=>false,'inputSettings'=>$input])
                                @break
                                @case('string')
                                @include('services.bpms2.components.Table.data.txtInput',['inputSettings'=>$input,'isStruct'=>false,'otherClass'=>''])
                                @break
                                @case('boolean')
                                @include('services.bpms2.components.Table.data.checkBox',['inputSettings'=>$input,'isStruct'=>false])
                                @break
                                @case('enum')
                                @include('services.bpms2.components.Table.data.selectBox',['inputSettings'=>$input,'oldData'=>$oldData,'index'=>$index,'key'=>$propertyKey,'isStruct'=>false])
                                @break
                                @case('long')
                                @include('services.bpms2.components.Table.data.txtInput',['inputSettings'=>$input,'otherClass'=>'long-input','isStruct'=>false])
                                @break
                                @case('money')
                                @include('services.bpms2.components.Table.data.txtInput',['inputSettings'=>$input,'otherClass'=>'money-input','isStruct'=>false])
                                @break
                                @case('textarea')
                                @include('services.bpms2.components.Table.data.textArea',['inputSettings'=>$input,'isStruct'=>false])
                                @break
                                @case("file")
                                @include('services.bpms2.components.Table.data.uploadDocument',['inputSettings'=>$input,'isStruct'=>false])
                                @break
                                @case("hyperlink")
                                @include('services.bpms2.components.Table.data.hyperlink',['inputSettings'=>$input,'isStruct'=>false])
                                @break
                                @case('radioBtn')
                                @include('services.bpms2.components.Table.data.radioButt',['inputSettings'=>$input,'isStruct'=>false])
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
</div>
@error("table.{$table->id}")
<p class="error-msg">{{$message}}</p>
@enderror

@pushonce('script')
    <script>
        const deleteImg = "{{asset('icons/delete(1).svg')}}";

    </script>
<script src="{{asset('assets/vendor/datatables/datatables.min.js')}}"></script>

@endpushonce
