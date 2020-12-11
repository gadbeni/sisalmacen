<div class="form-group">
	{{ Form::label('name', 'Nombre Usuario') }}
	{{ Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) }}
</div>
<hr>
<h3>Lista de roles</h3>
<div class="form-group">
	<ul class="list-unstyled">
		@foreach($roles as $role)
	    <li>
	        <label>
	        {{ Form::checkbox('roles[]', $role->id, null) }}
	        {{ $role->name }} <em>({{ $role->description ?: 'N/A'}})</em>
	        </label>
	    </li>
	    @endforeach
    </ul>
</div>
<div class="form-group">
	<!-- {{ Form::submit('Guardar', ['class' => 'btn btn-info']) }} -->
	<button type="submit" class="btn btn-outline-info"><i class="fas fa-save"></i> Guardar</button>
	<a href="{{route('users.index')}}" class="btn btn-outline-info"><i class="fas fa-history"></i> Volver a la Lista</a>
</div>