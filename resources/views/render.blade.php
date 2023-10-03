<div class="container">

    <div class="row mt-5 mb-5">
        <div class="col-10 offset-1 mt-5">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="text-white">Add User</h3>
                </div>
                <div class="card-body">

                    @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif

                    <form id="formData" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        @include('form')

                        <div class="form-group text-center mt-2">
                            <button class="btn btn-success btn-submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<strong> Search :
    <input type="text" data-url="{{ route('user.search') }}" class="search_data form-control"><br>
</strong>
<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th>Name</th>
        <th>Hobby</th>
        <th>Email</th>
        <th>Picture</th>
        <th width="280px">Action</th>
    </tr>
    <tbody id="reload_data" class="reload_data">
        @include('tableData')
    </tbody>

</table>
