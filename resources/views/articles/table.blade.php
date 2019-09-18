<div class="table-responsive">
  <table class="table" id="articles-table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Image</th>
        <th>Summary</th>
        <th>Content</th>
        <th colspan="3">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($articles as $article)
      <tr>
        <td>{!! $article->name !!}</td>
        <td>{!! $article->image !!}</td>
        <td>{!! $article->summary !!}</td>
        <td>{!! $article->content !!}</td>
        <td>
          {!! Form::open(['route' => ['articles.destroy', $article->id], 'method' => 'delete']) !!}
          <div class='btn-group'>
            <a href="{!! route('articles.show', [$article->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
            <a href="{!! route('articles.edit', [$article->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
            {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => 'ham()']) !!}
          </div>
          {!! Form::close() !!}
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
