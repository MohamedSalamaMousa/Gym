
<div class="row breadcrumbs-top">
    <div class="col-12">
        <h3 class="content-header-title float-start mb-0 me-2">{{$title}}</h3>
        <div class="breadcrumb-wrapper">
            <ol class="breadcrumb mt-1">
                <li class="breadcrumb-item">
                    <a href="{{route('AdminPanel')}}">{{trans('common.PanelHome')}}</a>
                </li>
                @if(isset($breadcrumbs))
                    @foreach($breadcrumbs as $item)
                        @if($item['url'] != '')
                            <li class="breadcrumb-item">
                                <a href="{{$item['url']}}">{{$item['text']}}</a>
                            </li>
                        @else
                            <li class="breadcrumb-item active">
                                {{$item['text']}}
                            </li>
                        @endif
                    @endforeach
                @endif
            </ol>
        </div>

    </div>
</div>
