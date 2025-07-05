</html>
<!DOCTYPE html>
<html>
  <head>
    <title>Welcome Email</title>
  </head>
  <body>
  <h2>Bonjour {{$user['firstname']}}  {{$user['lastname']}}</h2>
    <br/>

    Merci pour votre inscription.    <br/>
    Vous devez valider votre compte {{$user['email']}}.    <br/>
    Merci  de cliquer sur le lien suivant pour valider votre compte

    <a href="{{url('/api/verify',$user['remember_token'])}}"> <button  type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('VALIDER MON COMPTE') }}</button>.</a>
    <br/>

    <br/>

    <br/>
    Utilisez le lien suivant si le boutton ne s'affiche pas correctement :
    <br/>
    {{url('/api/verify',$user['remember_token'])}}
  </body>


  

<footer>
<p><div>{{ env('APP_NAME') }}</div>
<div>{{ env('APP_URL') }}</div></p>
</footer>
</html>

