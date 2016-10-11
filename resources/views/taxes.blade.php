@extends('layouts.app')
@section('content')
    <div class="row row-height" >
        <div class="col-lg-6 col-md-12">
            @include('tables.table',['box_title'=>'Taxes detailed 2015','url'=>'/user/taxes/detailed/2015','canvas_id'=>'taxes_table_2015','total'=>'true','moneyFormat'=>'Tax Amount','overlay'=>'1'])
        </div>
        <div class="col-lg-6 col-md-12">
            @include('tables.table',['box_title'=>'Taxes detailed E2016','url'=>'/user/taxes/detailed/2016','canvas_id'=>'taxes_table_2016','total'=>'true','moneyFormat'=>'Tax Amount','overlay'=>'0'])
        </div>
        <div class="col-lg-6 col-md-12">
            @include('charts.pie_chart',['box_title'=>'Total Taxes E2016','url'=>'/user/taxes/total/2016','canvas_id'=>'taxes_chart_2016','overlay'=>'1'])
        </div>
        <div class="col-lg-6 col-md-12">
            @include('charts.line_chart',['box_title'=>'Taxes Comparison','url'=>'/user/taxes/comparison','canvas_id'=>'taxes_comparison','overlay'=>'1'])
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Upload Taxes File</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <form method="post" action="/taxesUpload" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="control-label">Select Tax Year</label>
                            <select class="form-control" name="year">
                                <option>2014</option>
                                <option>2015</option>
                                <option>2016</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Select file</label>
                            <input name="taxfile" type="file" class="form-control">
                        </div>
                        {{ csrf_field() }}
                    </div>
                    <div class="box-footer">
                        <button class="btn btn-primary pull-right" type="submit">Send</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Uploaded taxes files</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @php
                            $path = env('S3_ENV','dev').'/'.Auth::user()->id.'_'.str_slug(Auth::user()->email).'/taxes/';
                            $directories=array();
                            try{
                                $directories = Storage::disk('s3')->directories($path);
                            }catch(Exception $e){
                            }
                            $i=0;
                        @endphp
                        <table class="table table-hover" style="border: 1px">
                            <tr>
                            <th>Year</th>
                            <th><i class="fa fa-file"></i> File</th>
                            <th><i class="fa fa-edit"></i> Options</th>
                            </tr>
                            @foreach ($directories as $directory)
                                @php
                                    $files = array();
                                    $file='';
                                    try{
                                        $files = Storage::disk('s3')->files($directory);
                                    }catch(Exception $e){

                                    }
                                @endphp
                                @foreach($files as $file)
                                    @php
                                        $i=$i+1;
                                    @endphp
                                    <tr>
                                        <td>
                                            {{ class_basename($directory) }}
                                        </td>
                                        <td >
                                            <a href="/getFile?f={{ base64_encode($file) }}">
                                            <span class="label label-default">
                                                <i class="fa fa-file-pdf-o"></i> {{ class_basename($file) }}
                                            </span>
                                            </a>
                                        </td>
                                        <td class="row-hidden">
                                            <span class="hover-btn">
                                                <a href="#">
                                                    <span id="r_{{ $i }}" class="label label-info " title="Rename file"><i class="fa fa-edit"></i></span>
                                                </a>
                                                <a href="#">
                                                    <span  id="d_{{ $i }}" class="label label-danger" title="Delete file"><i class="fa fa-trash"></i></span>
                                                </a>
                                            </span>
                                        </td>
                                    </tr>
                                    @push('scripts')
                                        <script>
                                            $('#r_{{ $i }}').on('click', function (e) {renameFile('{{ base64_encode($file) }}','{{ basename($file) }}');});
                                            $('#d_{{ $i }}').on('click', function (e) {deleteFile('{{ base64_encode($file) }}','{{ basename($file) }}');});
                                        </script>
                                    @endpush
                                @endforeach
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('modals')
    @include('layouts.forms.modal_form',
        array(
            'id'=>'rename_file_form',
            'header'=>'Rename file',
            'description'=>'',
            'cancel_button_label'=>'Cancel',
            'inputs'=>[
                ['label'=>'New file name','id'=>'rename_new_file name','type'=>'text'],
                ['label'=>'','id'=>'rename_old_file_name','type'=>'hidden']
            ],
            'submit_button_label'=>'Rename file','url'=>'/renameFile',
        ))
    @include('layouts.forms.modal_form',
        array(
            'id'=>'delete_file_form',
            'header'=>'Delete file',
            'description'=>'',
            'cancel_button_label'=>'Cancel',
            'inputs'=>[
                ['label'=>'','id'=>'delete_file_name','type'=>'hidden']
            ],
            'submit_button_label'=>'Delete file','url'=>'/deleteFile',))

    @include('layouts.modal_dialog',
    ['id'=>'mod_file_modal',
        'header'=>'File modification',
        'description'=>''])
@endpush

@push('scripts')
<script>
    function deleteFile(file_encode,file_name){
        $('#delete_file_name').attr('value',file_encode);
        $('#description_delete_file_form').html('Are you sure than you want to delete this file? <b>'+file_name.split(/[\\/]/).pop()+'</b>');
        $('#delete_file_form').modal('toggle');
        return true;
    }

    function renameFile(file_encode,file_name){
        $('#rename_old_file_name').attr('value',file_encode);
        $('#description_rename_file_form').html('Renaming file <b>'+file_name+'</b>');
        $('#rename_file_form').modal('toggle');
        return true;
    }

    $('#{{ 'delete_file_form_info_modal' }}').on('hidden.bs.modal', function () {
        location.reload();
    })

    $('#{{ 'rename_file_form_info_modal' }}').on('hidden.bs.modal', function () {
        location.reload();
    })
</script>
@endpush