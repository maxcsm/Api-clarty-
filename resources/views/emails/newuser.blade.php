
</html>
<!DOCTYPE html>
<html>
  <head>
    <title>Création nouveau compte</title>
  </head>
  <body>
  <p>Bonjour</p>
  <p> Votre compte vient d'être créé.</p>
  <p> Vous pouvez vous connecter via l'application. </p>
  <p> Identifiant : <b>{{$user['email']}} </b></p>
  <p> Vous pouvez maintenant vous connecter via le lien suivant : </p>
<div>{{ env('APP_URL_WEB') }}</div></p>
 Merci
</body>
<footer>
<b><div>{{ env('APP_NAME') }}</div></b>
</footer>
</html>

