
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
p{ font-size: 10px;}
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
<h5><strong>Contrat </strong></h5>
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
<td style="width: 100%;background-color:#BBBBBB;text-align:center;"> <p><b>CONTRAT</b></p></td></tr>
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

<p>
A. Prestations :
</p>
<p>
1. <b>{{$label2}}</b> de désinfection dans le cadre du bâtiment précipités contre <b>{{$label1}}</b> 
</p>
<p>
2. Zones de traitement :<b> {{$label3}} </b>
</p>


<p>
B. Garantie :
Dont le cadre d’un traitement unique d'une période non reconductible de <b> {{$label4}} </b>  </p>
<p>

<b> {{$label5}} </b>  € htva à la souscription du contrat et ensuite tous les <b> {{$label6}} </b> </p>

<p>2. a. Le contrat est conclu pour une durée minimale de <b> {{$label7}} </b> an(s)</p>

<p>
Les factures sont payables dès <b> {{$label9}} </b> jours réception, anticipativement. À défaut de paiement de la facture à son échéance, elle sera majorée sans mise en demeure préalable et dès la date d'échéance,
d'un montant forfaitaire et irréduct</p>


</td></tr>
</tbody>
</table>


<table style="width: 100.00%;border: solid;padding-top:100px;">
<tbody>
<tr style="height: 27px;text-align:center;">
<td style="width: 50%; height: 27px;font-size:10px;"><p><b> Signature pour entreprise </b></td>
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
<td style="width: 100%;background-color:#BBBBBB;text-align:center;"> <p><b> ENTREPRISE | 24 rue victor Hugo 75005
PARIS - 
Tél. : +33145454545 </b></p></td></tr>





</tbody>
</table>