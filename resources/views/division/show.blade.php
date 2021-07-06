@extends ('application.base')
@section('content')
    @includeIf("division.content.{$division}", compact('division'))
@endsection