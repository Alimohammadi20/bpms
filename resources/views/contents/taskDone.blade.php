@php
    if (isset($process['rootStep']['key'])){
        switch ($process['rootStep']['key']){
            case 'Auth':
                $key = 'احراز هویت غیرحضوری';
                break;
                case 'ReceptionEvaluation':
                $key = 'ارزیابی و اعتبارسنجی';
                break;
                case 'ConfirmOrder':
                $key = 'بررسی ثبت سفارش';
                break;
        }
    }else{
        $key = '';
    }
@endphp
<div class="container text-center py-5">
    <img src="{{asset('icons/sand-clock3.png')}}" alt="sand-clock3.png" class="img-fluid" style="width: 200px">
    <h4 style="color: #071A63;">{{trans('messages.task in agent')}}</h4>
    <p style="color: #071A63;">{{trans('messages.agent task',['title'=>$key])}}</p>
</div>
