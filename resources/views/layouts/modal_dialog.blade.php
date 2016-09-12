<!-- Modal -->
<div id="{{ $id or '$id'}}" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                @stack('modal-header')
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ $header or '$header' }}</h4>
            </div>
            <div class="modal-body" id="{{ $id or '$id'}}_description">
                <p>{{ $description or '' }}</p>
                @stack('modal-body')
            </div>
            <div class="modal-footer">
                @stack('modal-footer')
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ $cancel_button_label or 'Ok' }}</button>
            </div>
        </div>
    </div>
</div>