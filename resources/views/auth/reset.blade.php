@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Cambiar Clave</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
<!-- {{ url('/password/reset') }} -->
					<form class="form-horizontal" role="form" method="POST" action="{!! URL::action('WelcomeController@updatePassword'); !!}">
						<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
						<input type="hidden" name="user_id" value="{{$user_id}}">

						<div class="form-group">
							<label class="col-md-4 control-label">Usuario</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="email" value="{{$username}}" disabled>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Nueva Clave</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password" required>
							</div>
						</div>

						<!--div class="form-group">
							<label class="col-md-4 control-label">Confirmar Clave</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation">
							</div>
						</div-->

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Cambiar Clave
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
