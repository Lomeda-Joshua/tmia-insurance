<style>
    /* Custom link hover css */
    .custom-link-hover {
        color: inherit;
        transition: color 0.15s ease-in-out;
    }

    .custom-link-hover:hover {
        color: #cbdc35 !important; /* Change to your preferred hover color */
    }
</style>


<form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-inline">
    @csrf
    <a href="#" 
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
       class="text-decoration-none p-0 align-baseline custom-link-hover"
       style="cursor: pointer; color: inherit; font-size: inherit; font-family: inherit; line-height: inherit;">
        Or  {{ $slot->isEmpty() ? 'sign in as a different user' : $slot }}
    </a>
</form>