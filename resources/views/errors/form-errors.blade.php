@if(Session::has('success'))
	<div class="callout callout-success" style="margin: 0 15px 15px 15px;">
		<button type="button" class="close" onclick="$(this).parent('.callout').fadeOut(500)">×</button>
		<h4>Операция прошла успешно!</h4>
		<p>{{ Session::get('success') }}</p>
	</div>
@endif
@if(Session::has('error'))
	<div class="callout callout-danger" style="margin: 0 15px 15px 15px;">
		<button type="button" class="close" onclick="$(this).parent('.callout').fadeOut(500)">×</button>
		<h4>Ошибка!</h4>
		<p>{{ Session::get('error') }}</p>
	</div>
@endif
@if (count($errors) > 0) {{--Если есть ошибки валидности формы, выводим их--}}
<div class="callout callout-danger" style="margin: 0 15px 15px 15px;">
	<button type="button" class="close" onclick="$(this).parent('.callout').fadeOut(500)">×</button>
	<h4>Ошибки!</h4>
	<ul>
		@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif