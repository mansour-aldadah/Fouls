@extends('parent')

@section('title', 'إنشاء مستهلك رئيسي')

@section('header', 'إنشاء مستهلك رئيسي')

@section('content')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header ">
                <h3 class="card-title p-2"></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="form">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">اسم المستهلك</label>
                        <input type="text" class="form-control" id="name" placeholder="أدخل اسم المستهلك">
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="button" onclick="store()" class="btn btn-primary">إنشاء</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')

    <script>
        function store() {
            axios.post('/consumers', {
                    name: document.getElementById('name').value
                })
                .then(function(response) {
                    document.getElementById('form').reset();
                    showMessage(response.data);
                })
                .catch(function(error) {
                    showMessage(error.response.data);
                });
        }

        function showMessage(data) {
            Swal.fire({
                toast: true,
                icon: data.icon,
                title: data.message,
                showConfirmButton: false,
                position: 'top-start',
                timer: 3000
            });
        }
    </script>

@endsection
