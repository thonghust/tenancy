<div class="table-responsive">
    <table class="table" id="websites-table">
        <thead>
            <tr>
                <th>Uuid</th>
                <th>Customer Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($websites as $website)
            <tr>
                <td>{!! $website->uuid !!}</td>
                <td>{!! $website->customer_id !!}</td>
                <td>
                    {!! Form::open(['route' => ['websites.destroy', $website->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('websites.show', [$website->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
