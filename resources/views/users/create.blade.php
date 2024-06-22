@extends('parent')
@section('title', 'إضافة مستخدم')

@section('header', 'إضافة مستخدم')

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
                            value="{{ old('username') }}" placeholder="أدخل اسم المستخدم">
                    </div>
                    <div class="form-group">
                        <label for="password">كلمة المرور</label>
                        <input type="password" class="form-control" value="{{ old('password') }}" id="password"
                            name="password" placeholder="أدخل كلمة المرور">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">تأكيد كلمة المرور</label>
                        <input type="password" class="form-control" value="{{ old('password_confirmation') }}"
                            id="password_confirmation" name="password_confirmation" placeholder="تأكيد كلمة المرور">
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="button" onclick="store()" class="btn btn-primary">إضافة</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('script')

    <script>
        function store() {
            axios.post('/users', {
                    username: document.getElementById('username').value,
                    password: document.getElementById('password').value,
                    password_confirmation: document.getElementById('password_confirmation').value
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
