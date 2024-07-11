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
                        <label for="name">الاسم</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                            placeholder="أدخل الاسم ">
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
                    <div class="form-group" data-select2-id="13">
                        <label>نوع المستخدم</label>
                        <select class="form-control select2 select2-hidden-accessible" id="role" name="role"
                            style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                            <option value="">أدخل نوع المستخدم</option>
                            <option value="مستخدم" @if (old('role') == 'مستخدم') selected @endif> مستخدم
                            </option>
                            <option value="مستهلك"@if (old('role') == 'مستهلك') selected @endif> مستهلك
                            </option>
                        </select>
                    </div>
                    <div class="form-group consumer_id " style="display: none" data-select2-id="13">
                        <label>المستهلكين</label>
                        <select class="form-control select2 select2-hidden-accessible" id="consumer_id" name="consumer_id"
                            style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                            <option value="">اختر المستهلكين المسؤول عنهم </option>
                            @foreach ($consumers as $consumer)
                                <option value="{{ $consumer->id }}" @if (old('consumer_id') == $consumer->id) selected @endif>
                                    {{ $consumer->name }}
                                </option>
                            @endforeach
                        </select>
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
                    name: document.getElementById('name').value,
                    role: document.getElementById('role').value,
                    consumer_id: document.getElementById('consumer_id').value,
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
        $(document).ready(function() {
            $('#role').on('change', function() {
                var role = $(this).val();
                if (role) {
                    if (role == 'مستهلك') {
                        $('.consumer_id').css('display', 'block');
                    } else {
                        $('.consumer_id').css('display', 'none');
                    }
                } else {
                    $('.consumer_id').css('display', 'none');
                }
            })
        });


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
