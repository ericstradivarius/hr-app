@if(Session::has('error'))
    <div class="alert alert-danger">
        {{ Session::get('error') }}
    </div>
@endif

<form action="{{ route('two-factor-code') }}" method="POST">
    <input name="one_time_password" type="text">
    {{ csrf_field() }}

    <button type="submit">Authenticate</button>
</form>