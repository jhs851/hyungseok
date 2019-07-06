@extends('layouts.app')

@section('content')
    <search-view class="container" index="developments">
        <ais-search-box></ais-search-box>

        <ais-hits>
            <div slot="item" slot-scope="{ item }">
                <h2>@{{ item.title }}</h2>
            </div>
        </ais-hits>
    </search-view>
@stop
