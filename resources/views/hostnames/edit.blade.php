@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Hostname
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($hostname, ['route' => ['hostnames.update', $hostname->id], 'method' => 'patch']) !!}

                        @include('hostnames.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection