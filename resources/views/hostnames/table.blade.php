<div class="table-responsive">
    <table class="table" id="hostnames-table">
        <thead>
            <tr>
                <th>Fqdn</th>
                <th>Website Id</th>
                <th>Customer Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hostnames as $hostname)
            <tr>
                <td>{!! $hostname->fqdn !!}</td>
                <td>{!! $hostname->website_id !!}</td>
                <td>{!! $hostname->customer_id !!}</td>
                <td>
                    {!! Form::open(['route' => ['hostnames.destroy', $hostname->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('hostnames.show', [$hostname->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
