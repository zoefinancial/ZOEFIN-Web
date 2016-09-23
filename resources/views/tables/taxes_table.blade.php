<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">{{ $box_title }}</h3>
        <div class="box-tools pull-right">
            <i id="{{ $canvas_id }}_loading" class="fa fa-spinner fa-pulse fa-fw"></i>
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="{{ $canvas_id }}" class="tablesorter table table-striped table-hover" cellspacing="0" width="100%" class="">
                <thead>
                <tr>
                    <th>Year</th>
                    <th title="Percentage taken from your next dollar of taxable income. Why it matters? You need to know it to calculate what amount of your raise or bonus you’ll get to keep after taxes or whether it is worthwhile to contribute more to your tax-advantaged accounts">Marginal Tax Rate</th>
                    <th title="Total Tax Paid / Taxable Income. Why it matters?	Typically a more accurate reflection of what your overall tax bill than its marginal tax rate.">Effective Tax Rate</th>
                    <th>Taxes Paid</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
   @include('layouts.overlay')
</div>

@push('scripts')
    @include('tables.js.taxes_table_js',['canvas_id'=>$canvas_id])
@endpush