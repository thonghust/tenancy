<!-- Fqdn Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fqdn', 'Fqdn:') !!}
    {!! Form::text('fqdn', null, ['class' => 'form-control']) !!}
</div>

<!-- Redirect To Field -->
<div class="form-group col-sm-6">
    {!! Form::label('redirect_to', 'Redirect To:') !!}
    {!! Form::text('redirect_to', null, ['class' => 'form-control']) !!}
</div>

<!-- Force Https Field -->
<div class="form-group col-sm-6">
    {!! Form::label('force_https', 'Force Https:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('force_https', 0) !!}
        {!! Form::checkbox('force_https', '1', null) !!} 1
    </label>
</div>

<!-- Under Maintenance Since Field -->
<div class="form-group col-sm-6">
    {!! Form::label('under_maintenance_since', 'Under Maintenance Since:') !!}
    {!! Form::date('under_maintenance_since', null, ['class' => 'form-control','id'=>'under_maintenance_since']) !!}
</div>

@section('scripts')
    <script type="text/javascript">
        $('#under_maintenance_since').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection

<!-- Website Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('website_id', 'Website Id:') !!}
    {!! Form::number('website_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Customer Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('customer_id', 'Customer Id:') !!}
    {!! Form::number('customer_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('hostnames.index') !!}" class="btn btn-default">Cancel</a>
</div>
