
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark"><i class="fas fa-users"></i> Users</h1>
            </div>

        </div>
    </div>
</div>
<section class="content">
    <div class="row">
        <div class="col-md-8">
            <x-users
                method='list'
            ></x-users>
        </div>
        <div class="col-md-4">
            <x-users
                method='type'
            ></x-users>
        </div>
    </div>
</section>
