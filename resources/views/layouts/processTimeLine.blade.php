@php
    if ($process){
    $childrenStep = config('process.root_step_key')[$process["rootStep"]["key"]];
    }
@endphp

<div class="timeline-box">
    <div class="main-steps">
        <div class="steps steps-light pb-2 step-checkout">
            @if($process)

                @foreach(config('process.root_step_key') as $root)
                    <a class="step-item  {{$loop->index+1 < $process["rootStep"]["step"] ?'passed' : ''}}  {{$loop->index+1 == $process["rootStep"]["step"] ?'current' : ''}}">
                        <div
                            class="step-progress {{ ($loop->first) ? "first-progress" : "" }}  {{ ($loop->last) ? "last-progress" : "" }}">
                        </div>
                        <div class="step-label">
                            @if($loop->index+1 == $process["rootStep"]["step"])
                                <img src="{{asset("icons/{$root['passed_icon']}")}}" alt="image">
                            @elseif($loop->index+1 < $process["rootStep"]["step"])
                                <img src="{{asset("icons/{$root['current_icon']}")}}" alt="image">
                            @else
                                <img src="{{asset("icons/{$root['icon']}")}}" alt="image">
                            @endif
                            {{$root['name']}}
                        </div>
                    </a>
                @endforeach
            @endif
        </div>
    </div>
    <div class="detailed-steps">
        @if($process)
            <div class="timeline d-flex">
                <div class="line-timeline"></div>
                @foreach($childrenStep['children'] as $step)

                    <div
                        class="flex-fill text-center  {{$loop->index < $process["processStep"]["step"]-1?'active':''}} {{$process["processStep"]["step"]-1 ==$loop->index ? 'current' :''}}">
                        @if($loop->index < $process["processStep"]["step"]-1)
                            <img src="{{asset("icons/complete1.svg")}}" alt="complete1.svg">
                        @elseif($process["processStep"]["step"]-1 ==$loop->index)
                            <img src="{{asset("icons/Group 174.svg")}}" alt="image">
                        @else
                            <img src="{{asset("icons/Ellipse 9.svg")}}" alt="image">
                        @endif
                        <p>
                            {{$step['name']}}
                        </p>
                    </div>
                    @if(!$loop->last)
                        {{--                        <div class="timeline-process"></div>--}}
                    @endif
                    {{--                    <a class="step-item {{$loop->index < $process["processStep"]["step"]?'active':''}} {{$process["processStep"]["step"]-1 ==$loop->index ? 'current' :''}}"--}}
                    {{--                       href="#">--}}
                    {{--                        <div class="step-progress">--}}
                    {{--                            <span class="step-count">{{toFarsiNumber($loop->index+1)}}</span>--}}
                    {{--                        </div>--}}
                    {{--                                            <div class="child-step-label">--}}
                    {{--                                                {{$step['name']}}--}}
                    {{--                                            </div>--}}
                    {{--                                        </a>--}}
                @endforeach
            </div>
        @endif
    </div>
</div>
@push('script')

@endpush
