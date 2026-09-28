<form method="POST" action="{{ route('logout') }}" class="d-inline">
    @csrf
    <button type="submit" class="btn btn-link text-decoration-none p-0 align-baseline" style="cursor: pointer; background: none; border: none; color: inherit;">
        {{ $slot->isEmpty() ? 'Or sign in as a different user' : $slot }}
    </button>
</form>