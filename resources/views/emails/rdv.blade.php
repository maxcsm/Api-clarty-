<h2>Demande de rendez-vous</h2>
<br/>
<br/>
<br/>
Vous avez reçu un e-mail de <b> {{$user['lastname']}} {{$user['firstname']}}</b><br/>
Date du rendez-vous souhaité : <b>{{$user['jour']}} à {{$user['heure']}}</b><br/>
Nom : <b> {{$user['lastname']}}</b><br/>
Prénom: <b> {{$user['firstname']}}</b><br/>
Email: <b> {{$user['email']}}</b><br/>
Télephone: <b> {{$user['phone_number']}}</b><br/>
Sujet : <b> {{$user['subject']}}</b><br/>
Message: <b> {{$user['message']}}</b><br/>



<footer>
<p><div>{{ env('APP_NAME') }}</div>
<div>{{ env('APP_URL') }}</div></p>
</footer>
</html>




