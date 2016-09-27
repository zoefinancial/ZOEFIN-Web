<!-- Modal -->
<div id="{{ $id or '$id'}}" class="modal fade" role="dialog">
    <div class="modal-dialog" style="{{ $style or '' }}">
        <div class="box box-primary box-solid">
            <div class="box-header with-border">
                @yield('modal-header-'.$id)
                <h3 class="box-title">{{ $header or '$header' }}</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool close" data-dismiss="modal"><i class="fa fa-times"></i></button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="{{ $id or '$id'}}_description">
                <p id="description_{{ $id }}">{{ $description or '' }}</p>
                @yield('modal-body-'.$id)
            </div>
            <div class="modal-footer">
                @yield('modal-footer-'.$id)
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ $cancel_button_label or 'Ok' }}</button>
            </div>
            <div id="{{ $id }}_overlay" class="hidden"><i class="fa fa-spinner fa-pulse fa-fw"></i></div>
        </div>
    </div>
    {{--
    <div class="modal-dialog" style="{{ $style or '' }}">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                @yield('modal-header-'.$id)
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ $header or '$header' }}</h4>
            </div>
            <div class="modal-body" id="{{ $id or '$id'}}_description">
                <p id="description_{{ $id }}">{{ $description or '' }}</p>
                @yield('modal-body-'.$id)
                <div class="overlay"><i class="fa fa-spin fa-pulse"></i></div>
            </div>
            <div class="modal-footer">
                @yield('modal-footer-'.$id)
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ $cancel_button_label or 'Ok' }}</button>
            </div>
        </div>
    </div>
    --}}
</div>