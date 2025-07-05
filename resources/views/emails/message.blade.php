<!DOCTYPE html>
<html lang=&quot;en-US&quot;>
<head>
<meta charset=&quot;utf-8&quot;>
</head>
<body>
<h2>Message de rendez-vous</h2>
<div>

<div> Subject: yutu</div>
<div> Message: fregze</div>

Vous avez reçu un e-mail de <b> {{$user['lastname']}} {{$user['firstname']}}</b><br/>
Date du rendez-vous souhaité : <b>{{$user['jour']}} à {{$user['heure']}}</b><br/>
Nom : <b> {{$user['lastname']}}</b><br/>
Prénom: <b> {{$user['firstname']}}</b><br/>
Email: <b> {{$user['email']}}</b><br/>
Télephone: <b> {{$user['phone_number']}}</b><br/>
Sujet : <b> {{$user['subject']}}</b><br/>
Message: <b> {{$user['message']}}</b><br/>
</body>
<footer>
<p><div>{{ env('APP_NAME') }}</div>
<div>{{ env('APP_URL') }}</div></p>
</footer>
</html>
