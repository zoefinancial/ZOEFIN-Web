<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">{{ $box_title }}</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-7 col-xs-7">
                <div class="chart">
                    <canvas id="investments_pie_chart" style="padding-left:10px; padding-right:10px;"></canvas>
                </div>
            </div>
            <div class="hidden-lg hidden-md col-sm-5 col-xs-5">
                <div class="chart">
                    <canvas id="investments_bar_chart" style="padding-left:10px; padding-right:10px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    @include('charts.investments_chart_js',['url'=>'/user/investments','pie_canvas_id'=>'investments_pie_chart','bar_canvas_id'=>'investments_bar_chart'])
@endpush