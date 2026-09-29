<form method="POST" action="{{ route('logout') }}" class="d-inline">
    @csrf
    <button type="submit" 
        class="btn btn-link text-decoration-none p-0 align-baseline shadow-none border-0 bg-transparent" 
        style="cursor: pointer; color: inherit; font-size: inherit; font-family: inherit; line-height: inherit; user-select: text;">
    {{ $slot->isEmpty() ? 'Or sign in as a different user' : $slot }}
</button>
</form>