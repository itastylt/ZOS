  <div class="w-100">
    <header class="w-100 d-flex flex-wrap py-3 align-items-center mb-4 justify-content-between border-bottom">
	  <div class="pl-2 pr-2 d-flex flex-nowrap align-items-center">
	  	  <img width="100px" height="50px" src="https://i.imgur.com/FGg0adi.png">
		  <h6>Žaidimų organizavimo sistema</h6>
	  </div>

      <ul class="pl-2 pr-2 nav nav-pills">
        <li class="nav-item"><a href="/" class="nav-link" aria-current="page">Namai</a></li>
        <li class="nav-item"><a href="/TournamentsPage" class="nav-link">Turnyrai</a></li>
        @if(session()->get('is_administrator'))
          <li class="nav-item"><a href="{{ route('UsersPage.renderUsersPage')}}" class="nav-link">Naudotojai</a></li>
        @endif
        <li class="nav-item"><a href="/logout" class="nav-link">Atsijungti</a></li>
      </ul>
    </header>
  </div>
