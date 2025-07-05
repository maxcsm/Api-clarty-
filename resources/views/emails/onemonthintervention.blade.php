<h2>Intervention dans un mois</h2>
Vous avez reçu une nouvelle intervention dans un mois pour <b> {{$user['lastname']}} {{$user['firstname']}}, {{$user['company']}} </b><br/>
Date du rendez-vous souhaité : <b>{{$user['jour']}} à {{$user['heure']}}</b><br/>

Nom : <b> {{$user['lastname']}}</b><br/>
Prénom: <b> {{$user['firstname']}}</b><br/>
Sujet : <b> {{$user['subject']}}</b><br/>
Message: <b> {{$user['message']}}</b><br/>

Pour plus d'informations veuillez vous connecter à votre espace personnel. 


<footer>
<p><div>{{ env('APP_NAME') }}</div>
<div>{{ env('APP_URL_WEB') }}</div></p>
</footer>
</html>



