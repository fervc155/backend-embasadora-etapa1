

<html>
<head>
	<title>{{$data['subject']}}</title>

	<style type="text/css">
	body
	{
		font-family: sans-serif;
		background: lightblue;
		padding: 2rem;
	}
	.corpus	
	{
		background: white;
		padding: 2rem;
	}

	a.btn
	{
background:  lightblue;
    padding: 10px 1rem;
    margin-top: 1rem;
    text-decoration: none;
    color: white;
    cursor: pointer;
    border-radius: 6px;
	}
	h2
	{
		margin-top: 0;
	}


	</style>
</head>
<body>
	<div class="corpus">
		
	<h2>{{$data['subject']}}</h2>

	@foreach($data['text'] as $line)


	<p>
		{{$line}}
	</p>

	@endforeach
	<br>


	@if(isset($data['url']))
	<a href="{{$data['url']}}" class="btn">{{$data['btn_name']}}</a>

	@endif
	<br>
	<br>

	<hr>
	<p>
		Formulabs
	</p>
	<p>
		{{url('/')}}
	</p>
		@if(isset($data['url']))

	<small>
		Si el botón no funciona da clic en la siguiente liga o pégala en el navegador <a href="{{$data['url']}}">{{$data['url']}}</a>
	</small>
	@endif
	</div>
</body>
</html>