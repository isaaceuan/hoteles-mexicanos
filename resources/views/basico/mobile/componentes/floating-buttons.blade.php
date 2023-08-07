<footer class="floating-footer">
{{--    <span class="toggler px-2  bg-light color-white border-top border-left border-right rounded-top">--}}
{{--            <i class="fa fa-caret-down w-100"></i>--}}
{{--        </span>--}}
    <div class="container-fluid">

        @if('app.informacion' == Route::currentRouteName())
            <botones-flotantes-component
                :step="'informacion'">
            </botones-flotantes-component>
        @else
            <botones-flotantes-component>
            </botones-flotantes-component>
        @endif

    </div>
</footer>

