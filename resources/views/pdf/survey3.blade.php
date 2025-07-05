
<!DOCTYPE html>
<html lang="fr">
<head>
    <style>
      table, th, td {
      padding: 2px;
      border: 2px solid black;
      border-collapse: collapse;
      }

      .cell-highlight {
      border: 4px solid green;
}
p{ font-size: 14px;}
    </style>
  </head>

<table style="width: 100%; border-collapse: collapse;" border="1">
<tbody>
<tr>
<td style="width: 25%;"><img src="{{ public_path('/images/logo.png') }}" style="width: 200px;"></td>
<td style="width: 50.5613%;text-align:center;">
<div class="page" title="Page 1">
<div class="section">
<div class="layoutArea">
<div class="column">
<h5><strong>Feuille 
</strong></h5>
</div>
</div>
</div>
</div>
</td>

</tr>
</tbody>
</table>


<table style="width: 100.00%;border: solid; height: 40px;">
<tbody><tr >
<td style="width: 100%;background-color:#BBBBBB;text-align:center;"> <p><b>Feuille de Passage </b></p></td></tr>
</tbody>
</table>


<table style="width: 100.00%;border: solid;">
<tbody>

<tr >
<td style="width: 20%; height: 10px; text-align: left;">

<p>Date : <b>{{$docdate}}</b> <br> 

@foreach($users1 as $item)
<p>Client/Raison sociale : <b> {{$item->company}}</b> <br> 
Addresse de facturation : <b>  {{$item->shipping_address}} {{$item->shipping_cp}} {{$item->shipping_city}}</b> <br>
<b>  {{$item->shipping_state}} {{$item->shipping_country}}</b> <br>
Téléphone  : <b>   {{$item->shipping_phone}} </b> <br>
Téléphone autre  : <b>  {{$item->billing_phone}} </b> <br>
TVA : <b> {{$item->tva_number}} </b> <br>
Siret: <b>  {{$item->siret_number}} </b> <br>
<br> 
Personne à contacter et/ou ayant procuration pour valider les prestations:<br> 
Nom Prénom : <b>{{$item->salutation}} {{$item->firstname}} {{$item->lastname}} </b> <br> 
<b> {{$item->address}} {{$item->cp}} {{$item->city}}</b> <br>
<b>  {{$item->state}} {{$item->country}}</b> <br>
Mobile : <b> {{$item->phone_mobile}} </b> <br>
Téléphone :  <b>{{$item->phone_number}} </b> <br>
E-mail :  <b>  {{$item->email}} </b> <br>
@endforeach

</td>
</tr>
</tbody>
</table>




<table style="width: 100.00%;border: solid; height: 40px;">
<tbody><tr >
<td style="width: 100%;"> 

<p>Situation rencontrée ce jour :<b>{{$label1}}</b></p>
<p>Passage :<b>{{$label2}}</b></p>
<p><b>Rapport du technicien Pour Particulier</b></p>
<p>Insectes :<b>{{$label3}}</b></p>
<p>Rongeurs :<b>{{$label4}}</b></p>
<p>Pièces Traitée :<b>{{$label5}}</b></p>
<p>Produits Utilisés / Poducts Used :<b>{{$label6}}</b></p>
<p>Recommandations :<b>{{$label7}}</b></p>
<p>Recommandations Spécifiques :<b>{{$label8}}</b></p>

<p><b>Paiement</b></p>
<p>Prix :<b>{{$label9}} €</b></p>
<p>Mode Paiement :<b>{{$label10}}</b></p>


</td></tr>
</tbody>
</table>

<table style="width: 100.00%;padding-top:100px;">
@foreach($bloc1 as $item)
<img src="{{ public_path('/images/'.$item)}}" style="width: 330px;">
@endforeach

</table>

<table style="width: 100.00%;border: solid;padding-top:100px;">
<tbody>
<tr style="height: 27px;text-align:center;">
<td style="width: 50%; height: 27px;font-size:10px;"><p><b> Signature pour la S.P.R.L COPLATECK </b></td>
<td style="width: 50%; height: 27px;font-size:10px;"><p><b>Signature pour le client<b></p></td>
</tr>

<tr >
<td style="width: 20%; height: 10px; text-align: left;">
<p>Sous réserve d'approbation par la Direction avant exécution - paraphe:
@foreach($users1 as $item)
<p>Nom Prénom : <b> {{$item->firstname}} {{$item->lastname}} </b> </p>
@endforeach
<p>Date : {{$docdate}}
<img src="{{$img2}}" alt="Red dot" />

</td>


<td style="width: 20%; height: 10px; text-align: left;">

<p>Le soussigné, ci-dessus dénommé le client, déciare
explicilement qu'il conclut ce contrat dans le cadre de ses
activités prolessionnelles.</p>
@foreach($users2 as $item)
<p>Nom Prénom : <b> {{$item->firstname}} {{$item->lastname}} </b> </p>
@endforeach
<p>Date : {{$docdate}} </p>
<img src="{{$img1}}" alt="Red dot" />
</td>
</tr>
</tbody>
</table>


<table style="width: 100.00%;border: solid; height: 40px;">
<tbody><tr >
<td style="width: 100%;background-color:#BBBBBB;text-align:center;"> <p><b>SPR </b></p></td></tr>





</tbody>
</table>




































