<style>
    .workspace-header {
        max-width: 80%;
        margin: 0 auto;
        margin-bottom: 25px;
    }
    .badge-ps {
        margin: 0 0 15px 0;
        background-color: #006db0;
    }

    .badge-api {
        margin: 0 0 15px 0;
        background-color: #7145BD;
    }

    .badge-csv {
        margin: 0 0 15px 0;
        background-color: #FFC300;
    }

    .badge-excel {
        margin: 0 0 15px 0;
        background-color: #13B254;
    }

    .badge-sage {
        margin: 0 0 15px 0;
        background-color: #a1192e;
    }

    .badge-shopify {
        margin: 0 0 15px 0;
        background-color: #165BD3
    }
</style>
<div class="row workspace-header">
    <div class="col-6">
        <h3>Workspaces</h3>
    </div>
    <div class="col-6" style="text-align: right;">
        <a href="{{ url('/workspace') }}" class="btn btn-thundvel">+ New workspace</a>
    </div>
</div>