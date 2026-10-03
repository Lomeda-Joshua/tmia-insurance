<form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-inline">
    @csrf
    <a href="#" 
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
       class="text-decoration-none p-0 align-baseline link-danger"
       style="cursor: pointer; color: inherit; font-size: inherit; font-family: inherit; line-height: inherit;">
        {{ $slot->isEmpty() ? 'Or sign in as a different user' : $slot }}
    </a>
</form>