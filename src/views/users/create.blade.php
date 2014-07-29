@extends('cpanel::layouts')

@section('header')
<h1>Users</h1>
@stop

@section('breadcrumb')
@parent
<li>
    <a href="{{route('cpanel.users.index')}}">
        <i class="fa fa-user"></i>
        Users
    </a>
</li>
<li class="active">Create</li>
@stop

@section('content')
<div class="row">
    <div class="col-md-7 col-lg-offset-2">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Create a new user</h3>
            </div>
            <div class="panel-body">
                {{ Form::open(['route' => 'cpanel.users.store']) }}

                <!-- First Name field -->
                <div class="form-group">
                    {{ Form::label('first_name','First Name') }}
                    {{ Form::text('first_name',null,['class'=>'form-control']) }}
                </div>

                <!-- Last Name field -->
                <div class="form-group">
                    {{ Form::label('last_name','Last Name') }}
                    {{ Form::text('last_name',null,['class'=>'form-control']) }}
                </div>

                <!-- Email field -->
                <div class="form-group">
                    {{ Form::label('email','Email') }}
                    {{ Form::email('email',null,['class'=>'form-control']) }}
                </div>

                <!-- Password field -->
                <div class="form-group">
                    {{ Form::label('password','Password') }}
                    {{ Form::password('password',['class'=>'form-control']) }}
                </div>

                <!-- Password Confirmation field -->
                <div class="form-group">
                    {{ Form::label('password_confirmation','Confirm password') }}
                    {{ Form::password('password_confirmation',['class'=>'form-control']) }}
                </div>

                <div class="form-group">
                    <label for="groups">Groups</label>
                    <select id="groups" name="groups[]" class="select2 form-control" multiple="true">
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-3 form-group">
                        <label for="activate">Activate</label>
                        {{
                        Form::select('activate',['0' => 'No','1' => 'Yes'],
                        null,['class'=>'select2 form-control'])
                        }}
                    </div>
                </div>

                <div class="checkbox">
                    <label>
                        {{ Form::hidden('permission',0) }}
                        {{ Form::checkbox('permission',1) }} &nbsp;Set this user permissions after save?
                    </label>
                </div>

                <!-- Save field -->
                <div class="form-group">
                    {{ Form::submit('Save',['class'=>'btn btn-primary']) }}
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
</div>
@stop