@extends('layouts.app', ['writing' => true])

@section('content')
    <create-development-view ref="form" inline-template>
        <div>
            <markdown-helper></markdown-helper>

            <div class="container py-5">
                <div class="row">
                    <div class="col-12 p-3 p-md-6 bg-white shadow">
                        <form method="POST" action="{{ route('developments.store') }}">
                            @csrf

                            @include('developments.partials.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </create-development-view>
@stop

@section('script')
    <script>
        @foreach ($errors->all() as $message)
            toastr.error('{{ $message }}');
        @endforeach
    </script>
@stop
