@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid p-5">
        <div class="row mt-5 align-items-end">
            <div class="col-12">
                <div class="row align-items-end">
                    <div class="col-auto">
                        <h2 class="mb-3">
                            @lang('admin.notifications.read_notifications')
                        </h2>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="table-responsive bg-white z-depth-1 rounded-lg">
                            <table class="table table-hover text-center h5 font-weight-light mb-0">
                                <colgroup>
                                    <col style="width: 15%;">
                                    <col style="width: 10%;">
                                    <col>
                                    <col style="width: 12%;">
                                    <col style="width: 8%;">
                                </colgroup>

                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">type</th>
                                        <th scope="col">받은 사람</th>
                                        <th class="text-left" scope="col">메세지</th>
                                        <th scope="col">생성일</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($readNotifications as $notification)
                                        <tr>
                                            <td>{{ $notification->type }}</td>
                                            <td>
                                                <a href="{{ route('admin.users.show', $notification->notifiable->id) }}">
                                                    {{ $notification->notifiable->name }}
                                                </a>
                                            </td>
                                            <td class="text-left">{{ $notification->data['message'] }}</td>
                                            <td>{{ $notification->created_at->format('Y. m. d') }}</td>
                                            <td>
                                                <form class="d-inline ml-2" method="POST" action="{{ route('admin.notifications.destroy', $notification->id) }}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-link p-0" @click="destroy">
                                                        <i class="far fa-trash-alt text-black-50 h4 mb-0"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">
                                                @lang('admin.notifications.read_empty')
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{ $readNotifications->render() }}
                        </div>
                    </div>
                </div>

                <div class="row align-items-end mt-5">
                    <div class="col-auto">
                        <h2 class="mb-3">@lang('admin.notifications.unread_notifications')</h2>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="table-responsive bg-white z-depth-1 rounded-lg">
                            <table class="table table-hover text-center h5 font-weight-light mb-0">
                                <colgroup>
                                    <col style="width: 15%;">
                                    <col style="width: 10%;">
                                    <col>
                                    <col style="width: 12%;">
                                    <col style="width: 8%;">
                                </colgroup>

                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">type</th>
                                        <th scope="col">받은 사람</th>
                                        <th class="text-left" scope="col">메세지</th>
                                        <th scope="col">생성일</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($unreadNotifications as $notification)
                                        <tr>
                                            <td>{{ $notification->type }}</td>
                                            <td>
                                                <a href="{{ route('admin.users.show', $notification->notifiable->id) }}">
                                                    {{ $notification->notifiable->name }}
                                                </a>
                                            </td>
                                            <td class="text-left">{{ $notification->data['message'] }}</td>
                                            <td>{{ $notification->created_at->format('Y. m. d') }}</td>
                                            <td>
                                                <form class="d-inline ml-2" method="POST" action="{{ route('admin.notifications.mark', $notification->id) }}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-link p-0">
                                                        <i class="fas fa-book-reader text-black-50 h4 mb-0"></i>
                                                    </button>
                                                </form>

                                                <form class="d-inline ml-2" method="POST" action="{{ route('admin.notifications.destroy', $notification->id) }}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-link p-0" @click="destroy">
                                                        <i class="far fa-trash-alt text-black-50 h4 mb-0"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">
                                                @lang('admin.notifications.unread_empty')
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{ $unreadNotifications->render() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
