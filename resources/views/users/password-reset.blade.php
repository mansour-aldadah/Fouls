@extends('parent')
@section('title', 'تغيير كلمة المرور')

@section('header', 'تغيير كلمة المرور')

@section('content')

    <div class="container">
        <div class="card card-primary">
            <div class="card-header" style="float: right">
                <h3 class="card-title mt-2 d-block" style="float:right "> المستخدم: {{ $user->username }}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="form">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="oldPassword">كلمة المرور القديمة</label>
                        <input type="password" class="form-control" value="{{ old('oldPassword') }}" id="oldPassword"
                            name="oldPassword" placeholder="أدخل كلمة المرور القديمة">
                    </div>
                    <div class="form-group">
                        <label for="password">كلمة المرور الجديدة</label>
                        <input type="password" class="form-control" value="{{ old('password') }}" id="password"
                            name="password" placeholder="أدخل كلمة المرور الجديدة">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">تأكيد كلمة المرور الجديدة</label>
                        <input type="password" class="form-control" value="{{ old('password_confirmation') }}"
                            id="password_confirmation" name="password_confirmation" placeholder="تأكيد كلمة المرور الجديدة">
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="button" onclick="update({{ $user->id }})" class="btn btn-primary">تغيير</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('script')

    <script>
        function update(id) {
            console.log('test');
            axios.put('/users/password-reset/' + id, {
                    oldPassword: document.getElementById('oldPassword').value,
                    password: document.getElementById('password').value,
                    password_confirmation: document.getElementById('password_confirmation').value
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
