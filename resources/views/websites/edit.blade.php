@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Website
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($website, ['route' => ['websites.update', $website->id], 'method' => 'patch']) !!}

                        @include('websites.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection