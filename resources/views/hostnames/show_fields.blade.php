<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $hostname->id !!}</p>
</div>

<!-- Fqdn Field -->
<div class="form-group">
    {!! Form::label('fqdn', 'Fqdn:') !!}
    <p>{!! $hostname->fqdn !!}</p>
</div>

<!-- Redirect To Field -->
<div class="form-group">
    {!! Form::label('redirect_to', 'Redirect To:') !!}
    <p>{!! $hostname->redirect_to !!}</p>
</div>

<!-- Force Https Field -->
<div class="form-group">
    {!! Form::label('force_https', 'Force Https:') !!}
    <p>{!! $hostname->force_https !!}</p>
</div>

<!-- Under Maintenance Since Field -->
<div class="form-group">
    {!! Form::label('under_maintenance_since', 'Under Maintenance Since:') !!}
    <p>{!! $hostname->under_maintenance_since !!}</p>
</div>

<!-- Website Id Field -->
<div class="form-group">
    {!! Form::label('website_id', 'Website Id:') !!}
    <p>{!! $hostname->website_id !!}</p>
</div>

<!-- Customer Id Field -->
<div class="form-group">
    {!! Form::label('customer_id', 'Customer Id:') !!}
    <p>{!! $hostname->customer_id !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $hostname->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $hostname->updated_at !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{!! $hostname->deleted_at !!}</p>
</div>

