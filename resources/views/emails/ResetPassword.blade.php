@component('mail::message')
    #ایمیل فعالسازی

    @component('mail::button' , ['url' => \Illuminate\Support\Facades\Redirect::to('google.com')->with($code)])
        ریست پسورد
    @endcomponent

@endcomponent
