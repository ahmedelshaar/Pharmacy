@if (session('error'))
    <div class="alert alert-danger mt-3 text-center" onclick='$(this).fadeOut(500, function() { $(this).remove(); });'>
        {{ session('error') }}
    </div>
@endif
