@extends('admin.layouts.app')

@section('content')
    <create-development-view ref="form" inline-template>
        <div>
            <markdown-helper></markdown-helper>

            <div class="container py-5">
                <div class="row">
                    <div class="col-12 p-3 p-md-6 bg-white shadow">
                        <form method="POST" action="{{ route('admin.developments.update', $development->id) }}">
                            @csrf
                            @method('PUT')

                            @include('developments.partials.form')

                            <div class="form-group text-right">
                                <a href="{{ route('admin.developments.index') }}" class="btn btn-outline-primary">
                                    @lang('developments.cancel')
                                </a>

                                <button type="submit" class="btn btn-primary">
                                    @lang('developments.edit')
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </create-development-view>
@stop