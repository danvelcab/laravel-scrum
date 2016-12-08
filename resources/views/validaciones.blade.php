@if(Session::get('mensaje'))
    <script type="text/javascript">
        var variablejs = "<?= Session::get('mensaje') ?>" ;
    </script>
    @if(Session::get('error'))
        <script type="text/javascript">
            notificarError(variablejs);
        </script>
    @else
        <script type="text/javascript">
            notificar(variablejs);
        </script>
    @endif

@endif
@foreach($errors->all() as $error)
    <script type="text/javascript">
        var variablejs = "<?= $error ?>" ;
        notificarError(variablejs);
    </script>
@endforeach
