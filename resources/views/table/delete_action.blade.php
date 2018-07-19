<a href="{{ route($action['route'], [$row->getkey()]) }}" class="btn btn-primary btn-danger btn-xs"
    onclick="event.preventDefault();if(confirm('Confirmar exclusão?')){document.getElementById('form-delete-{{ $row->getkey() }}').submit();}">

    <span class="fas fa-trash-alt"></span> {{ $action['label'] }}

</a>

<form id="form-delete-{{ $row->getkey() }}"
    action="{{ route($action['route'], [$row->getkey()]) }}"
    method="POST" style="display: none;">
        @csrf
        @method('DELETE')
</form>
