@if (session('success'))
    <div class="alert alert-success mt-3 text-center" onclick='$(this).fadeOut(500, function() { $(this).remove(); });'>
        {{ session('success') }}
    </div>
@endif
