@if (session()->has('msg'))
<div class='bg-green-500 bottom-2 fixed p-2 right-3 rounded-md text-sm text-white'
    x-data = "{ show: true }"
    x-init = "setTimeout(() => show = false, 4000)"
    x-show = "show"
>
    <p>{{ session('msg') }}</p>
</div>
@endif

@if (session()->has('err_msg'))
<div class='bg-red-500 bottom-2 fixed p-2 right-3 rounded-md text-sm text-white'
    x-data = "{ show: true }"
    x-init = "setTimeout(() => show = false, 4000)"
    x-show = "show"
>
    <p>{{ session('err_msg') }}</p>
</div>
@endif
