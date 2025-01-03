<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>{{ env('APP_NAME') }}</title>
	<style>
		* {
		  margin: 0;
		  padding: 0;
		}
		body {
		  font-family: "opensanscondensed", sans-serif;
		  font-size: 14px;
		}

		#new_invoice {
		  width: 100%;
		  margin: 0 auto;
		}
		#new_header div {
		  display: inline-table;
		  width: 49%;
		  text-align: right;
		}
		#topSection .topSectionRow {
		  display: inline-table;
		  vertical-align: text-top;
		}
		table.no-border {
		  border: 0px solid gray;
		}
		.no-border tr,
		.no-border td,
		.no-border th {
		  border: 0px;
		  text-align: left;
		  font-size: 12px;
		  line-height: 1;
		}
		#topSection {
		  display: inline-block;
		}
		#leftSectin {
		  width: 65%;
		}
		#rightSectin {
		  width: 34.59%;
		}
		#rightSectin .row {
		  padding: 5px;
		}
		#rightSectin .row .rowTitle {
		  display: inline-table;
		  width: 40%;
		}
		#leftSectin .row .rowData {
		  display: inline-table;
		  width: 58%;
		}
		#leftSectin .row .rowTitle {
		  display: inline-table;
		  width: 42%;
		}
		#rightSectin .row .rowData {
		  display: inline-table;
		  width: 58%;
		}

		/footer section/ #footerSection {
		  margin-top: 20px;
		}
		#footerSection .topSectionRow {
		  display: inline-table;
		}
		#footerLeftSectin {
		  width: 65%;
		  position: relative;
		}
		#footerRightSectin {
		  width: 33%;
		  border-left: 1px solid gray;
		}

		#footerLeftSectin .row {
		  padding: 2px 2px 2px 5px;
		  border-bottom: 1px solid gray;
		}
		#footerRightSectin .row {
		  padding: 5px;
		  padding: 21px 6px 0px 16px;
		  border-bottom: 1px solid gray;
		}
		#footerRightSectin .row .rowTitle {
		  display: inline-table;
		  width: 57%;
		}
		#footerRightSectin .row .rowData {
		  display: inline-table;
		  width: 42%;
		}
		#footerLeftSectin .row .rowTitle {
		  display: inline-table;
		  width: 15%;
		}
		#footerLeftSectin .row .rowData {
		  display: inline-table;
		  width: 58%;
		}

		#page-wrap {
		  width: 800px;
		  margin: 0 auto;
		}

		table {
		  border-collapse: collapse;
		  font-size: 14px;
		}
		table td,
		table th {
		  border: 1px solid gray;
		  padding: 5px;
		  width: 340px;
		 
		}

		#header {
		  height: 15px;
		  width: 100%;
		  margin: 20px 0;
		  background: #222;
		  text-align: center;
		  color: white;
		  font: bold 15px "opensanscondensed", sans-serif;
		  text-decoration: uppercase;
		  letter-spacing: 20px;
		  padding: 8px 0px;
		}

		#title {
		  height: 85px;
		  width: 100%;
		  margin: 5px 0;
		  text-align: center;
		  color: #fff;
		  font: bold 20px "opensanscondensed", sans-serif;
		  text-decoration: uppercase;
		  letter-spacing: 3px;
		  padding: 5px 0px;
		  background: #1a5c09;
		}

		#logan {
		  height: 20;
		  width: 100%;
		  margin: 5px 0;
		  text-align: center;
		  color: #999999;
		  font: bold 16px "opensanscondensed", sans-serif;
		  text-decoration: uppercase;
		  letter-spacing: 1px;
		  padding: 8px 0px;
		  font-style: italic;

		  border: 1px solid gray;
		}
		#subject {
		  border: none;
		  height: 28px;
		  width: 654px;
		  margin: 5px 0;
		  color: #000000;
		  font: bold 14px "opensanscondensed", sans-serif;
		}
		.proposalname {
		  padding-left: 30px;
		}

		#leftSectin .row .rowTitle.proposalmobile {
		  display: inline-table;
		  width: 13%;
		}

		#discription {
		  border: none;

		  min-height: 200px;
		  height: 70px;
		  width: 100%;
		  margin: 5px 0;
		  color: #000000;
		  font: bold 14px "opensanscondensed", sans-serif;
		}

		#free_content {
		  height: 525px;
		  width: 100%;
		  margin: 5px 0;
		  color: #000000;
		  font: bold 14px "opensanscondensed", sans-serif;
		}
		#only_content {
		  height: 710px;
		  width: 100%;
		  margin: 5px 0;
		  color: #000000;
		  font: bold 14px "opensanscondensed", sans-serif;
		}

		#address {
		  width: 400px;
		  height: 150px;
		  float: left;
		}
		#customer {
		  overflow: hidden;
		}

		#logo {
		  text-align: right;
		  float: right;
		  position: relative;
		  margin-top: 25px;
		  border: 1px solid #fff;
		  max-width: 540px;
		  max-height: 100px;
		  overflow: hidden;
		}
		#logo:hover,
		#logo.edit {
		  border: 1px solid gray;
		  margin-top: 0px;
		  max-height: 125px;
		}
		#logoctr {
		  display: none;
		}
		#logo:hover #logoctr,
		#logo.edit #logoctr {
		  display: block;
		  text-align: right;
		  line-height: 25px;
		  background: #eee;
		  padding: 0 5px;
		}
		#logohelp {
		  text-align: left;
		  display: none;
		  font-style: italic;
		  padding: 10px 5px;
		}
		#logohelp input {
		  margin-bottom: 5px;
		}
		.edit #logohelp {
		  display: block;
		}
		.edit #save-logo,
		.edit #cancel-logo {
		  display: inline;
		}
		.edit #image,
		#save-logo,
		#cancel-logo,
		.edit #change-logo,
		.edit #delete-logo {
		  display: none;
		}
		#customer_title {
		  font-size: 14px;
		  font-weight: bold;
		  float: left;
		  width: 300px;
		  height: 100px;
		}

		#meta {
		  margin-top: 1px;
		  width: 300px;
		  float: right;
		}
		#meta td {
		  text-align: right;
		}
		#meta td.meta-head {
		  text-align: left;
		  background: #eee;
		}
		#meta td textarea {
		  width: 100%;
		  height: 20px;
		  text-align: right;
		}

		#items {
		  clear: both;
		  width: 100%;
		  margin: 0px 0 0 0;
		  border: 1px solid gray;
		}
		#items th {
		  background: #eee;
		}
		#items tr.item-row td {
		  border: 0;
		  vertical-align: top;
		}
		#items td.description {
		  width: 300px;
		}
		#items td.item-name {
		  width: 175px;
		}
		#items td.description textarea,
		#items td.item-name textarea {
		  width: 100%;
		}
		#items td.total-line {
		  border-right: 0;
		  text-align: right;
		}
		#items td.total-value {
		  border-left: 0;
		  padding: 20px;
		}
		#items td.total-value textarea {
		  height: 20px;
		  background: none;
		}
		#items td.balance {
		  background: #eee;
		}
		#items td.blank {
		  border: 0;
		}

		#terms {
		  text-align: center;
		  margin: 20px 0 0 0;
		}
		#terms h5 {
		  text-transform: uppercase;
		  font: 13px "opensanscondensed", sans-serif;
		  letter-spacing: 10px;
		  padding: 0 0 8px 0;
		  margin: 0 0 8px 0;
		}
		#terms textarea {
		  width: 100%;
		  text-align: center;
		}

		.nrt1 {
		  width: 800px;
		  height: 180px;
		  float: left;
		}
		.nrt2 {
		  width: 320px;
		  height: 300px;
		  float: right;
		  margin-top: -130px;
		  letter-spacing: 2px;
		}
		.nrt3 {
		  margin-top: 160px;
		}

		.topSectionRow#footerRightSectin {
		  height: 240px;
		}
		.right-section-part {
		  height: 35px;
		}
		.proposal-left-content {
		  padding: 20px 0px;
		}

		.proposal-left-content {
		  padding: 6px 0px;
		}
		.right-section-part {
		  height: 28px;
		}
		#title {
		  height: 30px;
		}
		#footerSection {
		  margin-top: 0px;
		  border: 1px solid gray;
		  border-top: 0px;
		}
		.topSectionRow#footerRightSectin {
		  height: auto;
		}
		#footerRightSectin .row {
		  padding: 9px 0px 0px 9px;
		  border-bottom: 1px solid gray;
		  display: flex;
		  width: 98.5%;
		}
		table td,
		table th {
		  width: inherit;
		 
		  font-size: 12px;
		}
		#footerRightSectin {
		  font-size: 12px;
		}
		div {
		 
		}
		.logo-section {
		  width: 225px;
		  margin-top: 15px;
		}

	</style>
</head>
<body>
	<table style="width: 100%" class="no-border">
		<tr>
			<td style="width: 60%;">
				<img src="./img/logo-n.png" class="logo-section">
			</td>
			<td style="text-align: right; font-size: 13px;">
				<strong>{{ env('APP_NAME') }}</strong><br>
				<span>{{ $proFormaInvoice->billingAddress->address }}</span><br>
				{{ $proFormaInvoice->billingAddress->email }}<br>
				{{ $proFormaInvoice->billingAddress->mobilenum }}
				@if($proFormaInvoice->gst_enabled==1)
				<br>
				<strong>GST:</strong> {{ $proFormaInvoice->billingAddress->gst }}
				@endif
			</td>

		</tr>
	</table>
	<div id="title" style="text-transform: uppercase;">Travel Invoice</div>
	<br>
	<div>
		<table id="items" style="border: 0px;">
			<tr style="border: 0px; vertical-align: top; padding: 0; margin: 0;">
				<td style="border: 0px; vertical-align: top; text-align: left; width: 50%; padding: 0; margin: 0;" width="50%">
					<table id="items" style="width: 100%;" width="100%">
						<tr style="text-align: left;">
							<th style="width: 90px; text-align: left;">Bill To</th>
							<td>{{$proFormaInvoice->name}}</td>
						</tr>

						<tr style="text-align: left;">
							<th style="text-align: left;">Mobile </th>
							<td>{{$proFormaInvoice->mobile}}</td>
						</tr>
						<tr style="text-align: left;">
							<th style="text-align: left;">Email</th>
							<td>{{$proFormaInvoice->email}}</td>
						</tr>
						<tr style="text-align: left;">
							<th style="text-align: left;">Billing&nbsp;Add.</th>
							<td>{{$proFormaInvoice->address}}</td>
						</tr>
					</table>
				</td>
				<td style="border: 0px; vertical-align: top; text-align: left; width: 50%; padding: 0 0 0 15px; margin: 0 0 0 15px;" width="100%">
					<table id="items" style="width: 100%; float: right;">
						<tr style="text-align: left;">
							<th style="width: 90px; text-align: left;">From</th>
							<td>{{ env('APP_NAME') }}</td>
						</tr>
						<tr style="text-align: left;">
							<th style="text-align: left;">Invoice No</th>
							<td>{{ $proFormaInvoice->invoice_number }}</td>
						</tr>
						<tr style="text-align: left;">
							<th style="text-align: left;">Date</th>
							<td>{{ \Carbon\Carbon::parse($proFormaInvoice->date)->format('d, M Y') }}</td>
						</tr>
						<tr style="text-align: left;">
							<th style="text-align: left;">Total</th>
							<td>{{ $proFormaInvoice->currency->icon }}&nbsp;{{ number_format($proFormaInvoice->grand_total, 2) }}</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</br>
	<br>
	<table id="items">
		<thead>
			<tr style="text-align: left;">
				<th style="width:65%">DESCRIPTION</th>
				<th width="10%">PAX</th>
				<th style="width: 80px;">PRICE</th>
				<th style="width: 80px;">TOTAL</th>
			</tr>
		</thead>
		<tbody>
			@forelse ($proFormaInvoice->proFormaInvoiceDetails as $detail)
			<tr>
				<td>{{ $detail->description }}</td>
				<td>{{ $detail->pax }}</td>
				<td style="text-align: right;">{{ number_format($detail->price, 2) }}</td>
				<td style="text-align: right;">{{ number_format($detail->total, 2) }}</td>
			</tr>
			@empty
			@endforelse

			<tr>
				<td rowspan="3">
					@if($proFormaInvoice->remarks_enabled != '1')
					<strong style="padding-left: 15px; padding-top: 15px;">
						For {{ env('APP_NAME') }}
					</strong>
					<br><br><br><br>
					<strong style="padding-left: 15px; padding-bottom: 15px;">
						Authorized Signatory
						<br>
					</strong>
					@endif
				</td>
				<th colspan="2" style="width: 150px;text-align: left;">Grand Total</th>
				<td style="text-align: right;">{{ $proFormaInvoice->currency->icon }}&nbsp;{{ number_format($proFormaInvoice->grand_total, 2) }}</td>
			</tr>
			<tr>
				<th colspan="2" style="width: 150px;text-align: left;">Advance</th>
				<td style="text-align: right;">{{ $proFormaInvoice->currency->icon }}&nbsp;{{ number_format($proFormaInvoice->advance, 2) }}</td>
			</tr>
			<tr>
				<th colspan="2" style="width: 150px;text-align: left;">Due</th>
				<td style="text-align: right;">{{ $proFormaInvoice->currency->icon }}&nbsp;{{ number_format($proFormaInvoice->due, 2) }}</td>
			</tr>

              <!-- <tr>
                 <th colspan="4" style="width: 150px;text-align: left;">Amount in words: twelve thousands nine  hundred  and eighty only</th>
             </tr> -->
         </tbody>
     </table>
     
     <table class="no-border">
     	<tr>
     		<th colspan="2"><strong>Bank account Details:</strong></th>
     	</tr>
     	<tr>
     		<td>Account&nbsp;name</td>
     		<td>{{ $proFormaInvoice->bankDetail->account_name }}</td>
     	</tr>

     	<tr>
     		<td>Bank&nbsp;Name</td>
     		<td>{{ $proFormaInvoice->bankDetail->bank_name }}</td>
     	</tr>
     	<tr>
     		<td>Account&nbsp;No</td>
     		<td>{{ $proFormaInvoice->bankDetail->account_number }}</td>
     	</tr>
     	<tr>
     		<td>IFSC&nbsp;Code</td>
     		<td>{{ $proFormaInvoice->bankDetail->ifsc_code }}</td>
     	</tr>
     	<tr>
     		<td>Branch&nbsp;Address</td>
     		<td>{{ $proFormaInvoice->bankDetail->branch_address }}</td>
     	</tr>
     	<tr>
     		<td>UPI</td>
     		<td>{{ $proFormaInvoice->bankDetail->upi_number }}</td>
     	</tr>
     </table>

     @if(!empty($proFormaInvoice->remarks)  &&  ($proFormaInvoice->remarks_enabled == '1'))
     <hr>
     	<div class="row" style="padding: 0px 11px 7px 5px;">
	     	<small style="text-align: left;">
	     		{!! nl2br($proFormaInvoice->remarks) !!}
	     	</small>
	     </div>
	 @endif

	 <br>
	 @if(!empty($proFormaInvoice->show_system_gen)  &&  ($proFormaInvoice->show_system_gen == '1'))
     	<div class="row" style="padding: 0px 11px 7px 5px;">
	     	<h6 style="text-align: center; text-transform: capitalize;"><br>
	     		THIS IS A SYSTEM GENERATED INVOICE, NO STAMP REQUIRED
	     	</h6>
	     </div>
	 @endif

</div>
<div id="logan">“Thank you for providing business.”</div>

</div>
</body>
</html><?php /*PATH /home2/gofactz/tourism.gofactz.com/resources/views/admin/invoice_pdf_template.blade.php ENDPATH*/ ?>