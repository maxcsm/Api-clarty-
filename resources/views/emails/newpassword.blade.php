
</html>
<!DOCTYPE html>
<html>
  <head>
    <title>Nouveau mot de passe</title>
  </head>
  <body>

  <br/>
  <p>Bonjour</p>
   Vous avez demandé un nouveau mot de passe pour votre compte.   <br/>
   <br/>

   Mot de passe temporaire :  <h2>{{$user['password']}}  </h2>  <br/>
   <br/>

   Merci
   <br/>
 
  </body>
  <footer>
  <p><div>{{ env('APP_NAME') }}</div>
<div>{{ env('APP_URL_WEB') }}</div></p>
</footer>
</html>
