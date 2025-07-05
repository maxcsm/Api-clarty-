<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>{{ $invoice->name }}</title>
      

        <style >
            html {
                line-height: 1.15;
                margin: 0;
            }

            body {
                font-weight: 400;
                line-height: 1.5;
                color: #212529;
                background-color: #fff;
                font-size: 10px;
                margin: 36pt;
            }

            h4 {
                margin-top: 0;
                margin-bottom: 0.5rem;
            }

            p {
                margin-top: 0;
                margin-bottom: 1rem;
            }

            strong {
                font-weight: bolder;
            }

            img {
                vertical-align: middle;
                border-style: none;
            }

            table {
                border-collapse: collapse;
            }

            th {
                text-align: inherit;
            }

            h4, .h4 {
                margin-bottom: 0.5rem;
                font-weight: 500;
                line-height: 1.2;
            }

            h4, .h4 {
                font-size: 1.5rem;
            }

            .table {
                width: 100%;
                margin-bottom: 1rem;
                color: #212529;
            }

            .table th,
            .table td {
                padding: 0.75rem;
                vertical-align: top;
            }

            .table.table-items td {
                border-top: 1px solid #dee2e6;
            }

            .table thead th {
                vertical-align: bottom;
                border-bottom: 2px solid #dee2e6;
            }

            .mt-5 {
                margin-top: 3rem !important;
            }

            .pr-0,
            .px-0 {
                padding-right: 0 !important;
            }

            .pl-0,
            .px-0 {
                padding-left: 0 !important;
            }

            .text-right {
                text-align: right !important;
            }

            .text-center {
                text-align: center !important;
            }

            .text-uppercase {
                text-transform: uppercase !important;
            }
            * {
                font-family: "DejaVu Sans";
            }
            body, h1, h2, h3, h4, h5, h6, table, th, tr, td, p, div {
                line-height: 1.1;
            }
            .party-header {
                font-size: 1.5rem;
                font-weight: 400;
            }
            .total-amount {
                font-size: 12px;
                font-weight: 700;
            }
            .border-0 {
                border: none !important;
            }
            .cool-gray {
                color: #6B7280;
            }
        </style>
    </head>

    <body>
        {{-- Header --}}
        @if($invoice->logo)
            <img src="{{ $invoice->getLogo() }}" alt="logo" height="100">
        @endif

        <table class="table mt-1">
            <tbody>
                <tr>
                    <td class="border-0 pl-0" width="70%">
                        <h4 class="text-uppercase">
                            <strong>Facture N° {{ $invoice->getSerialNumber() }}</strong>
                        </h4>
                    </td>
                    <td class="border-0 pl-0">
                       
                  
                        <p> Date : <strong>{{ $invoice->getDate() }}</strong></p>
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- Seller - Buyer --}}
        <table class="table">
            <thead>
                <tr>
                    <th class="border-0 pl-0 party-header" width="48.5%">
                       
                    </th>
                    <th class="border-0" width="3%"></th>
                    <th class="border-0 pl-0 party-header">
                       Client
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="px-0">
                    
                            <p>
                            <strong>MERYFORME</strong> </br>
                            95 place de la Fontaine </br>
                            73420 Méry </br>
                            meryforme@gmail.com</br>
                            0776922433</br>
                            </p>
                    
                    </td>
                    <td class="border-0"></td>
                    <td class="px-0">
                 
                            <p class="buyer-name">
                                <strong>{{ $invoice->buyer->company }}</strong> </br>
                                <strong>{{ $invoice->buyer->lastname }} {{ $invoice->buyer->firstname }}</strong> </br>
                                <strong>{{ $invoice->buyer->shipping_address }} </strong> </br>
                                <strong>{{ $invoice->buyer->shipping_cp }},  {{ $invoice->buyer->shipping_city }}</strong> </br>
                                <strong>{{ $invoice->buyer->shipping_phone }} </strong> </br>
                                <strong>{{ $invoice->buyer->tva_number }}</strong> </br>
                                <strong>{{ $invoice->buyer->siret_number }}</strong> </br>
                            </p>
                  
                       

                       
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- Table --}}
        <table class="table table-items">
            <thead>
                <tr>
                    <th scope="col" class="border-0 pl-0">{{ __('invoices::invoice.description') }}</th>
                    @if($invoice->hasItemUnits)
                        <th scope="col" class="text-center border-0">{{ __('invoices::invoice.units') }}</th>
                    @endif
                    <th scope="col" class="text-center border-0">Qte</th>
                    <th scope="col" class="text-right border-0">Prix </th>
                    @if($invoice->hasItemDiscount)
                        <th scope="col" class="text-right border-0">{{ __('invoices::invoice.discount') }}</th>
                    @endif
                    @if($invoice->hasItemTax)
                        <th scope="col" class="text-right border-0">{{ __('invoices::invoice.tax') }}</th>
                    @endif
                    <th scope="col" class="text-right border-0 pr-0">Sous total</th>
                </tr>
            </thead>
            <tbody>
                {{-- Items --}}
                @foreach($invoice->items as $item)
                <tr>
                    <td class="pl-0">
                        {{ $item->title }} </br>

                        @if($item->description)

                        {!! $item->description!!} 
                        @endif
                    </td>
                    @if($invoice->hasItemUnits)
                        <td class="text-center">{{ $item->units }}</td>
                    @endif
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">
                        {{ $invoice->formatCurrency($item->price_per_unit) }}
                    </td>
                    @if($invoice->hasItemDiscount)
                        <td class="text-right">
                            {{ $invoice->formatCurrency($item->discount) }}
                        </td>
                    @endif
                    @if($invoice->hasItemTax)
                        <td class="text-right">
                            {{ $invoice->formatCurrency($item->tax) }}
                        </td>
                    @endif

                    <td class="text-right pr-0">
                        {{ $invoice->formatCurrency($item->sub_total_price) }}
                    </td>
                </tr>
                @endforeach
                {{-- Summary --}}
                @if($invoice->hasItemOrInvoiceDiscount())
                    <tr>
                        <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                        <td class="text-right pl-0">{{ __('invoices::invoice.total_discount') }}</td>
                        <td class="text-right pr-0">
                            {{ $invoice->formatCurrency($invoice->total_discount) }}
                        </td>
                    </tr>
                @endif
                @if($invoice->taxable_amount)
                    <tr>
                        <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                        <td class="text-right pl-0">Sous-total HT</td>
                        <td class="text-right pr-0">
                            {{ $invoice->formatCurrency($invoice->taxable_amount) }}
                        </td>
                    </tr>
                @endif
                @if($invoice->tax_rate)
                    <tr>
                        <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                        <td class="text-right pl-0">TVA</td>
                        <td class="text-right pr-0">
                            {{ $invoice->tax_rate }}%
                        </td>
                    </tr>
                @endif
                @if($invoice->hasItemOrInvoiceTax())
                    <tr>
                        <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                        <td class="text-right pl-0">Total TVA </td>
                        <td class="text-right pr-0">
                            {{ $invoice->formatCurrency($invoice->total_taxes) }}
                        </td>
                    </tr>
                @endif
                @if($invoice->shipping_amount)
                    <tr>
                        <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                        <td class="text-right pl-0">{{ __('invoices::invoice.shipping') }}</td>
                        <td class="text-right pr-0">
                            {{ $invoice->formatCurrency($invoice->shipping_amount) }}
                        </td>
                    </tr>
                @endif
                    <tr>
                        <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                        <td class="text-right pl-0">TOTAL </td>
                        <td class="text-right pr-0 total-amount">
                            {{ $invoice->formatCurrency($invoice->total_amount) }}
                        </td>
                    </tr>
            </tbody>
        </table>


  
                

<p><b>A payer avant : le : {{ $invoice->buyer->due_date }}</b></p>     


<P><HR NOSHADE></P>


<b>Conditions d’utilisation<b>

<p>    
L’Association Méryforme régie par la loi du 1er juillet 1901 et le décret du 16 août 1901, fondée en 1995, s’affilie
à la Fédération Française Sport pour Tous, reconnue d'Utilité Publique par décret du 16 Juillet 1973.
Elle a pour objet de promouvoir et de développer les activités physiques, sportives, culturelles et conviviales de
détente et de loisirs pour tous les âges et dans tous les milieux. Elle considère ces activités comme un élément
important de l’éducation, de la culture, de la santé publique, de l’intégration et de la participation à la vie sociale.
Le présent règlement intérieur est établi en application de l’article é0 des statuts de l’Association. Il s’applique à
tous les membres de l’Association.
</p>

<p>  
ARTICLE 1 : Adhésions
Au moment de leur adhésion, les membres adhérents doivent s’acquitter d’une cotisation annuelle dont le
montant est fixé annuellement par l’Assemblée Générale sur proposition du Bureau. Cette cotisation inclut le
coût de la licence fédérale qui comprend l’assurance.
Toute cotisation versée à l’Association est définitivement acquise. Il ne saurait être exigé un remboursement de
cotisation en cours d’année en cas de démission ou d’exclusion d’un membre.
Les personnes désirant adhérer à l’Association doivent remplir un bulletin d’adhésion (papier ou en ligne).
Pour les mineurs de moins de 16 ans, ce bulletin sera rempli et signé par un représentant légal, accompagné d’un
formulaire d’autorisation parentale dûment rempli.
Remboursement
En cas d’inaptitude temporaire à la pratique du sport (grossesse, problèmes de santé, modifications des activités
professionnelles, …) et sur présentation d’un justificatif, l’adhésion sera suspendue et le terme du contrat sera
reporté pour une durée égale à celle de la suspension, avec report éventuel sur la saison suivante.
En cas d’arrêt définitif, à titre exceptionnel uniquement et pour raison grave motivée (raisons professionnelles ou
de santé) accompagnée d’un justificatif, il sera procédé à un remboursement prorata temporis après déduction
d’une somme forfaitaire couvrant les frais de dossier. Cette somme sera réévaluée en même temps que les tarifs
annuels.
Tout trimestre entamé est dû.
Les réclamations doivent être adressées à l’adresse mail de l’Association : meryforme@gmail.com
</p>


<P><HR NOSHADE></P>




<p  class="text-center" > <b>MERYFORME - 95 place de la Fontaine 73420 Méry - association 1901</b> </p>







        <script type="text/php">
            if (isset($pdf) && $PAGE_COUNT > 1) {
                $text = "Page {PAGE_NUM} / {PAGE_COUNT}";
                $size = 10;
                $font = $fontMetrics->getFont("Verdana");
                $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
                $x = ($pdf->get_width() - $width);
                $y = $pdf->get_height() - 35;
                $pdf->page_text($x, $y, $text, $font, $size);
            }
        </script>
    </body>
</html>
