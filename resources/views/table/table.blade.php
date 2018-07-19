<form action="{{ url()->current() }}" method="GET" class="form-inline">
    <div class="form-grupo">
        <div class="input-group">
            <div class="input-group-addon">
                <span class="fas fa-search fa-w-16 fa-2x"></span>
            </div>
            <input type="text" class="form-control" name="search" placeholder="Pesquisar" value="{{ \Request::get('search') }}">
        </div>

    </div>
    <button type="submit" class="btn btn-primary">Pesquisar</button>
</form>
<br>
@if(count($table->rows()))
{!! $table->rows()->appends(['search' => \Request::get('search'),'field_order' => \Request::get('field_order'),'order' =>\Request::get('order')])->links() !!}
<table class="table table-striped">
    <thead>
        <tr>

            @foreach ($table->columns() as $column )
                <th data-name="{{ $column['name'] }}">
                    {{ $column['label'] }}
                @if(isset($column['_order']))
                        @php
                            $icons = [
                                1       => 'fas fa-sort',
                                'asc'   => 'fas fa-sort-amount-down',
                                'desc'  => 'fas fa-sort-amount-up',
                            ];
                        @endphp
                        <a id="{{ $column['name'] }}" href="javascript:void(0)">
                            <span class="{{$icons[$column['_order']]}}"></span>
                        </a>
                @endif
                </th>
            @endforeach

            @if(count($table->actions()))
                <th> Ações  </th>
            @endif

        </tr>
    </thead>
    <tbody>
        @foreach ($table->rows() as $rows)
            <tr>
                @foreach ($table->columns() as $column )
                    <td> {{ $rows->{$column['name']} }}   </td>
                @endforeach

                @if (count($table->actions()))
                    <td style="width: 30%">
                    @foreach ($table->actions() as $action )
                        @include($action['template'],[
                            'row'=>$rows,
                            'action'=>$action
                        ])
                    @endforeach
                    </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
{!! $table->rows()->appends(['search' => \Request::get('search'),'field_order' => \Request::get('field_order'),'order' =>\Request::get('order')])->links() !!}
@else
<table class="table">
    <tr>
        <td>Nenhum registro encontrado!</td>
    </tr>
</table>
@endif

@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        //$('#table-search>thead>tr>th[data-name]>a'))
        $("#{{ $column['name'] }}")
            .click(function(){

                var anchor = $(this);
                var field = anchor.closest('th').attr('data-name');
                var order =
                    anchor.find('span').hasClass('fas fa-sort-amount-up') || anchor.find('span').hasClass('fas fa-sort')
                    ? 'asc':'desc';
                var url = "{{url()->current()}}?";

                @if(\Request::get('page'))
                    url += "page={{\Request::get('page')}}&";
                @endif
                @if(\Request::get('search'))
                    url += "search={{\Request::get('search')}}&";
                @endif
                url+='field_order='+field+'&order='+order;
                window.location = url;
            })
    });
</script>
@endpush
