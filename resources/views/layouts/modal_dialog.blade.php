<!-- Modal -->
<div id="{{ $id or '$id'}}" class="modal fade" role="dialog">
    <div class="modal-dialog" style="{{ $style or '' }}">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                @yield('modal-header-'.$id)
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ $header or '$header' }}</h4>
            </div>
            <div class="modal-body" id="{{ $id or '$id'}}_description">
                <p>{{ $description or '' }}</p>
                @yield('modal-body-'.$id)
            </div>
            <div class="modal-footer">
                @yield('modal-footer-'.$id)
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ $cancel_button_label or 'Ok' }}</button>
            </div>
        </div>
    </div>
</div>