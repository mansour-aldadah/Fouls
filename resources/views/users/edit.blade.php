@extends('parent')
@section('title', 'تعديل مستخدم')

@section('header', 'تعديل مستخدم')

@section('content')
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
                        <label for="username">اسم المستخدم</label>
                        <input type="text" class="form-control" id="username" name="username"
                            value="@if (old('username')) {{ old('username') }} @else {{ $user->username }} @endif"
                            placeholder="أدخل اسم المستخدم">
                    </div>
                    <a href="{{ route('users.password-reset', ['user' => $user]) }}" class="btn btn-danger">تغيير كلمة
                        المرور</a>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="button" onclick="update({{ $user->id }})" class="btn btn-primary">تعديل</button>
                </div>
            </form>
        </div>
    </div>

@endsection


@endsection

@section('script')

<script>
    function update(id) {
        axios.put('/users/' + id, {
                username: document.getElementById('username').value,
            })
            .then(function(response) {
                window.location.href = '/users/';
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
