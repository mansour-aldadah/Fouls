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
                    <div class="form-group">
                        <label for="name">الاسم</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="@if (old('name')) {{ old('name') }} @else {{ $user->name }} @endif"
                            placeholder="أدخل الاسم">
                    </div>
                    <div class="form-group" data-select2-id="13">
                        <label>النظام</label>
                        <select class="form-control select2 select2-hidden-accessible" id="system" name="system"
                            style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                            <option value="">أدخل النظام</option>
                            <option value="2"
                                @if (old('system') == '2') selected @elseif(App\Models\UserSystem::where('user_id', $user->id)->first()->system_id == '2') selected @endif>
                                المحروقات
                            </option>
                            <option
                                value="1"@if (old('system') == '1') selected @elseif(App\Models\UserSystem::where('user_id', $user->id)->first()->system_id == '1') selected @endif>
                                الأرشيف
                            </option>
                        </select>
                    </div>
                    <div class="form-group" data-select2-id="13">
                        <label>نوع المستخدم</label>
                        <select class="form-control select2 select2-hidden-accessible" id="role" style="width: 100%;"
                            name="role" data-select2-id="1" tabindex="-1" aria-hidden="true">
                            <option value="">أدخل نوع المستخدم</option>
                            <option value="مستخدم"
                                @if (old('role') == 'مستخدم') selected @elseif($user->role == 'مستخدم') selected @endif>
                                مستخدم
                            </option>
                            <option value="مدير"
                                @if (old('role') == 'مدير') selected @elseif($user->role == 'مدير') selected @endif>
                                مدير
                            </option>
                            <option value="مستهلك" id="opCons"
                                @if (old('role') == 'مستهلك') selected @elseif($user->role == 'مستهلك') selected @endif>
                                مستهلك
                            </option>
                        </select>
                    </div>
                    <div class="form-group consumer_id" data-select2-id="13" style="display: none">
                        <label>المستهلكين</label>
                        <select class="form-control select2 select2-hidden-accessible" id="consumer_id" name="consumer_id"
                            style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                            <option value="">اختر المستهلكين المسؤول عنهم </option>
                            @foreach ($consumers as $consumer)
                                <option value="{{ $consumer->id }}"
                                    @if (old('consumer_id') == $consumer->id) selected  @elseif($user->consumers->contains($consumer)) selected @endif>
                                    {{ $consumer->name }}
                                </option>
                            @endforeach
                        </select>
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
                role: document.getElementById('role').value,
                name: document.getElementById('name').value,
                system_id: document.getElementById('system').value,
                consumer_id: document.getElementById('consumer_id').value
            })
            .then(function(response) {
                window.location.href = '/users/';
                showMessage(response.data);
            })
            .catch(function(error) {
                showMessage(error.response.data);
            });
    }
    $(document).ready(function() {
        var role = $('#role').val();
        if (role) {
            if (role == 'مستهلك') {
                $('.consumer_id').css('display', 'block');
            } else {
                $('.consumer_id').css('display', 'none');
            }
        } else {
            $('.consumer_id').css('display', 'none');
        }
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
        $('#system').on('change', function() {
            var system = $(this).val();
            if (system) {
                $('.userType').css('display', 'block');
                if (system == 'fouls') {
                    $('#opCons').css('display', 'block');
                } else {
                    $('#opCons').css('display', 'none');
                }
            } else {
                $('.userType').css('display', 'none');
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
