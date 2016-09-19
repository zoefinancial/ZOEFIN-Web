<form id="plaid-form" action="/authenticate" method="post">
{{ csrf_field() }}
</form>
@push('scripts')
<!-- To use Link with longtail institutions on Connect, set the
data-longtail attribute to 'true'. See the Parameter Reference for
additional documentation. -->
<script
        src="https://cdn.plaid.com/link/stable/link-initialize.js"
        data-client-name="Client Name"
        data-form-id="plaid-form"
        data-key="f45b0aa65a6e53ff7f67688c1cbc70"
        data-product="connect"
        data-env="tartan"
        data-longtail="true">
</script>
@endpush