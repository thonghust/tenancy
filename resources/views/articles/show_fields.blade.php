<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $article->id !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{!! $article->name !!}</p>
</div>

<!-- Image Name Field -->
<div class="form-group">
    {!! Form::label('image', 'Image:') !!}
    <p>{!! $article->image !!}</p>
</div>

<!-- Summary Field -->
<div class="form-group">
    {!! Form::label('summary', 'Summary:') !!}
    <p>{!! $article->summary !!}</p>
</div>

<!-- Content Field -->
<div class="form-group">
    {!! Form::label('content', 'Content:') !!}
    <p>{!! $article->content !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $article->updated_at !!}</p>
</div>

