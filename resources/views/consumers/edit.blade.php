@extends('parent')

@section('title', 'تعديل مستهلك رئيسي')

@section('header', 'تعديل مستهلك رئيسي')

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
                        <input type="text" class="form-control" id="name" name="name"
                            value="@if (old('name')) {{ old('name') }} @else {{ $consumer->name }} @endif"
                            placeholder="أدخل اسم المستهلك">
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="button" onclick="update({{ $consumer->id }})" class="btn btn-primary">تعديل</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')

    <script>
        function update(id) {
            axios.put('/consumers/' + id, {
                    name: document.getElementById('name').value
                })
                .then(function(response) {
                    window.location.href = '/consumers';
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
