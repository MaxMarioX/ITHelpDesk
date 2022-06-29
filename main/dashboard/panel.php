<div class="Dashboard">
    <div class="Panel">
        <div class="Panel-A">
            <h1>BS-HELPDESK</h1>
            <h2>v1.0.0 beta</h2>
        </div>
        <div class="Panel-B">
                <div class="MenuLogin">
                        <img src="graphics/user.png">
                        <ul class="navigationlogin">
                            <li><a href="#">Mariusz Plaskota</a>
                                <ul class="subnav">
                                    <li><img src="graphics/refresh.png"><a href="#">Ustawienia</a></li>
                                    <li><img src="graphics/add-ticket.png"><a href="#" onclick="LogOutNow()">Wyloguj się</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
            </div>
    </div>
    <div class="NewTickets-Panel">
        <div class="Menu">
            <img src="graphics/new-ticket.png">
            <ul class="navigation">
                <li><a href="#">Nowe zgłoszenia</a>
                    <ul class="subnav">
                        <li><img src="graphics/refresh.png"><a href="#" onclick="RefreshNewTickets()">Odśwież</a></li>
                        <li><img src="graphics/add-ticket.png"><a href="#" onclick="CreateNewTicket()">Dodaj zgłoszenie</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="NewTickets">
        <div class="DynamicDataForNewTickets">

        </div>
    </div>
    <div class="EscalatedTickets-Panel">
        <div class="Menu">
            <img src="graphics/work-ticket.png">
                <ul class="navigation">
                    <li><a href="#">Przejęte zgłoszenia</a>
                        <ul class="subnav">
                            <li><img src="graphics/refresh.png"><a href="#">Odśwież</a></li>
                            <li><img src="graphics/add-ticket.png"><a href="#" onclick="ShowMyTickets()">Moje zgłoszenia</a></li>
                            <li><img src="graphics/refresh.png"><a href="#">Wszystkie zgłoszenia</a></li>
                            <li><img src="graphics/refresh.png"><a href="#">Archiwum</a></li>
                        </ul>
                    </li>
                </ul>
        </div>
    </div>
    <div class="EscalatedTickets">
        <div class="DynamicDataForEscalatedTickets">

        </div>       
    </div>
</div>
<div class="Shadow"></div>
<div class="InfoBox"></div>