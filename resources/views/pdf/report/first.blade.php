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
				<div class="col-12">
			    <h1 class="h1">Reporte de actividades: Etapa 1</h1>
			    <h4>Fecha: {{$report['start']}} - {{$report['end']}}</h4>
			    <h4>Usuario: {{$report['user']}}</h4>
			    <h5>Cuestionarios</h5>
				<table class="table"  cellspacing="0" cellpadding="0">

					<thead>
						<tr>
							<th>Cuestionarios respondidos</th>
							<th>Cuestionarios aun en observacion</th>
							<th>Cuestionarios potenciales</th>
							
						</tr>
					</thead>
					<tbody>
						 <tr>
						 	<td>{{$report['answers_created']}}</td>
						 	<td>{{$report['answers_observation']}}</td>
						 	<td>{{$report['answers_potential']}}</td>

						 </tr>
					</tbody>
				</table>


			 <h5>Cotizaciones</h5>
				<table class="table"  cellspacing="0" cellpadding="0">

					<thead>
						<tr>							
							<th>Cotizaciones creadas</th>
							<th>Cotizacion recien enviadas</th>
							<th>Cotizacion primer llamada</th>
							<th>Cotizacion segunda llamada</th>
							<th>Cotizacion tercer llamada</th>
							<th>Cotizacion cancelada</th>
							<th>Cotizacion aprobada</th>
						</tr>
					</thead>
					<tbody>
						 <tr>
						 	<td>{{$report['quotes_created']}}</td>
						 	<td>{{$report['quotes_email']}}</td>
						 	<td>{{$report['quotes_first_call']}}</td>
						 	<td>{{$report['quotes_second_call']}}</td>
						 	<td>{{$report['quotes_third_call']}}</td>
						 	<td>{{$report['quotes_cancelled']}}</td>
						 	<td>{{$report['quotes_approved']}}</td>
						 </tr>
					</tbody>
				</table>
				<h5>Citas</h5>
				<table class="table"  cellspacing="0" cellpadding="0">

					<thead>
						<tr>							
							<th>Citas creadas</th>
							<th>Citas agendadas/atendidas</th>
						</tr>
					</thead>
					<tbody>
						 <tr>
						 	<td>{{$report['appointments_created']}}</td>
						 	<td>{{$report['appointments_scheduled']}}</td>
						 </tr>
					</tbody>
				</table>
								<h5>Clientes</h5>
				<table class="table"  cellspacing="0" cellpadding="0">

					<thead>
						<tr>							
							<th>clientes registrados</th>
						</tr>
					</thead>
					<tbody>
						 <tr>
						 	<td>{{$report['clients']}}</td>
						 </tr>
					</tbody>
				</table>
				<h5>Comentarios</h5>
				<p>{{$report['comments']}}</p>
				</div>
			</div>
		 
		</div>

				<div class="footer" ></div>

	</body>
</html>