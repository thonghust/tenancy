<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $website->id !!}</p>
</div>

<!-- Uuid Field -->
<div class="form-group">
    {!! Form::label('uuid', 'Uuid:') !!}
    <p>{!! $website->uuid !!}</p>
</div>

<!-- Customer Id Field -->
<div class="form-group">
    {!! Form::label('customer_id', 'Customer Id:') !!}
    <p>{!! $website->customer_id !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $website->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $website->updated_at !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{!! $website->deleted_at !!}</p>
</div>

<!-- Managed By Database Connection Field -->
<div class="form-group">
    {!! Form::label('managed_by_database_connection', 'Managed By Database Connection:') !!}
    <p>{!! $website->managed_by_database_connection !!}</p>
</div>

