@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid p-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <div class="d-flex align-items-center mr-auto">
                            <img class="avatar avatar-sm mr-2" src="{{ $user->avatar }}" alt="">
                            {{ $user->name }}
                        </div>

                        <div class="d-flex">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary btn-sm">
                                @lang('admin.users.edit')
                            </a>

                            <form class="d-inline ml-2" method="POST" action="{{ route('admin.users.destroy', $user->id) }}">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm" @click="destroy">
                                    @lang('admin.users.destroy')
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="form-group row align-items-center">
                            <div class="col-md-4 col-form-label text-md-right">@lang('validation.attributes.email')</div>

                            <div class="col-md-6">
                                {{ $user->email }}
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <div class="col-md-4 col-form-label text-md-right">@lang('admin.users.active_status')</div>

                            <div class="col-md-6">
                                @if ($user->hasVerifiedEmail)
                                    <span class="text-success">@lang('admin.users.active')</span>
                                @else
                                    <span class="text-danger">@lang('admin.users.unactive')</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <div class="col-md-4 col-form-label text-md-right">@lang('admin.users.is_admin')</div>

                            <div class="col-md-6">
                                @if ($user->isAdmin)
                                    <span class="text-success">@lang('admin.users.admin')</span>
                                @else
                                    <span class="text-danger">@lang('admin.users.general')</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <div class="col-md-4 col-form-label text-md-right">@lang('admin.users.created_at')</div>

                            <div class="col-md-6">
                                {{ $user->created_at->format('Y. m. d') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
