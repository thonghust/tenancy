@if(Auth::user()->name == "Admin")
<li class="{{ Request::is('website*') ? 'active' : '' }}">
    <a href="{!! route('websites.index') !!}"><i class="fa fa-newspaper-o"></i><span> Website</span></a>
</li>

<li class="{{ Request::is('customer*') ? 'active' : '' }}">
    <a href="{!! route('customers.index') !!}"><i class="fa fa-user"></i><span>Customer</span></a>
</li>

<li class="{{ Request::is('hostname*') ? 'active' : '' }}">
    <a href="{!! route('hostnames.index') !!}"><i class="fa fa-server"></i><span> Hostname</span></a>
</li>
@else
<li class="{{ Request::is('article*') ? 'active' : '' }}">
    <a href="{!! route('articles.index') !!}"><i class="fa fa-newspaper-o"></i><span> Article</span></a>
</li>
@endif