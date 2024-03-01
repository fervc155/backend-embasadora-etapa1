<html>
	<head>	
		<style>

			@page { 
				margin: 4rem 3rem; 
			}

			*{
				font-family: sans-serif;
				font-size: 14px;
			}
			h1{
				font-size: 2rem;
			}

			.small{
				font-size: 12px;
			}

			.text-center{
				text-align: center;
			}

			.ingredients{
				font-size: 12px;
				font-weight: lighter;
			}

			.mt-3{
				margin-top: 3rem;
			}
			.total{
				font-size: 2rem;
			}

			.container{
				width: 95%;
				padding: 1rem;
			}

			table.table{
				width: 100%;

			}

			thead,tr::nth-child(2n){
				background-color: #eaeaeb;
				margin: 0;
				border: none;
			}			
			thead,tr:nth-child(2n){
				background-color: #eaeaeb;
				margin: 0;
				border: none;
			}

			td,th{
				text-align: left;
				font-size: 12px;
				margin: 0;
				border: none;
				padding: 5px;
			}

			.fwb{
				font-weight: bold;
			}

			.row{
				display: flex;
				flex-wrap: wrap;
			}

			.d-block{
				display: block;
			}

			.col-12{
				width: 100%;
			}

			.col-6{
				width: 50%;
			}
			.left{
				float: left;
			}
		    .right{
				float: right;
			}
			
			.header{

				margin-top: -4rem;
				background-position: top center;
				background-size: contain;
				background-repeat: no-repeat;
				@include('../bg-header')
				width:100%;
				height:140px;
				display:block;
			}

			.footer{
				@include('../bg-footer')				
				width:100%;
				height:200px;
				display:block;
				position:absolute;
				background-position: center center;
				background-size: contain;
				background-repeat: no-repeat;
				bottom:-4rem;
				left:0;
			}

			.bold{
				font-weight: bold;
			}

			.separator{
				height: 300px;

			}
		</style>
	</head>
	
	<body style="width: 100%;">
		
		<div class="header" ></div>

		<div class="container">
			<div class="row justify-content-end">
				<div class="col-6 left ">
					<p class="bold">
						CLIENTE
					</p>	
					<div class="small">
						
					<span class="d-block">Nombre: {{$quote->client_name}}</span>
					<span class="d-block">Correo: {{$quote->email}}</span>
					<span class="d-block">Telefono: {{$quote->phone}}</span>
					</div>			

					
				</div>
				<div class="col-6 right">
					<p class="bold">
						EMPRESA
					</p>
					<p class="small">
						{{$quote->header}}
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-12 mt-3">
					
		<h1 class="h1">{{$quote->title}}</h1>

		<table class="table"  cellspacing="0" cellpadding="0">

			<thead>
				<tr>
					<th>Producto</th>
					<th>Contenido</th>
					<th>Precio unitario</th>
					<th>Piezas</th>
					<th>Iva (Si incluye)</th>
					<th>Subtotal</th>
				</tr>
			</thead>
			<tbody>
				<?php $total=0;$iva=0;?>
				@foreach(json_decode($quote->content) as $product)
				<tr>
					<td width="40%"><span class="fwb">{{$product->name}}</span> <span class="ingredients">{{$product->ingredients}}</span></td>
					<td>{{$product->unit_amount}}{{$product->unit}}</td>
					<td>{{$product->price}}</td>
					<td>{{$product->count}}</td>
					<td>${{round($product->iva,2)}} {{$quote->currency}}</td>
					<td>${{round($product->total,2)}} {{$quote->currency}}</td>
					<?php $total+=$product->total; $iva+=$product->iva ?>
				</tr>
								@endforeach
				<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>IVA: ${{round($iva)}}{{$quote->currency}}</td>
					
					<td>Total <span class="total">${{round($total,2)}}</span>{{$quote->currency}}</td>
				</tr>
			</tbody>
		</table>
					
			
				</div>
			</div>
			<br><br><br>
			<p class="text-justify mt-5">
				{{$quote->first_footer}}
			</p>
			<p class=" small text-center">
				{{$quote->second_footer}}
			</p>
		</div>

				<div class="footer" ></div>

	</body>
</html>