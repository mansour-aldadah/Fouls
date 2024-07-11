@extends('parent')

@section('title', 'إضافة رحلة')

@section('header', 'إضافة رحلة')

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
                    <div class="form-group" data-select2-id="13">
                        <label>المستهلك</label>
                        <select class="form-control select2 select2-hidden-accessible" id="sub_consumer_name"
                            name="sub_consumer_name" style="width: 100%;" data-select2-id="1" tabindex="-1"
                            aria-hidden="true">
                            <option value="">اختر المستهلك</option>
                            @foreach ($subConsumers as $subConsumer)
                                <option value="{{ $subConsumer->id }}"
                                    @if (old('sub_consumer_name') == $subConsumer->id) selected @elseif($travel->sub_consumer_id == $subConsumer->id) selected @endif>
                                    {{ $subConsumer->details }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="road">وجهة الرحلة</label>
                        <input type="text" class="form-control" id="road" name="road"
                            value="@if (old('road')) {{ old('road') }} @else {{ $travel->road }} @endif"
                            placeholder="أدخل وجهة الرحلة">
                    </div>
                    <div class="form-group">
                        <label for="cause">سبب الرحلة</label>
                        <input type="text" class="form-control" id="cause" name="cause"
                            value="@if (old('cause')) {{ old('cause') }} @else {{ $travel->cause }} @endif"
                            placeholder="أدخل سبب الرحلة">
                    </div>
                    <div class="form-group">
                        <label for="date">تاريخ الرحلة</label>
                        <input type="date" class="form-control" id="date" name="date"
                            @if (old('date')) value="{{ \Carbon\Carbon::parse(old('date'))->format('Y-m-d') }}" @else value="{{ $travel->date }}" @endif
                            placeholder="أدخل تاريخ الرحلة">
                    </div>
                    {{-- <div class="form-group">
                        <label for="recordBefore">قراءة العدّاد قبل الرحلة </label>
                        <input type="text" class="form-control" id="recordBefore" name="recordBefore"
                            value="@if (old('recordBefore')) {{ old('recordBefore') }} @else {{ $travel->recordBefore }} @endif"
                            placeholder="أدخل قراءة العدّاد قبل الرحلة">
                    </div>
                    <div class="form-group">
                        <label for="recordAfter">قراءة العدّاد بعد الرحلة</label>
                        <input type="text" class="form-control" id="recordAfter" name="recordAfter"
                            value="@if (old('recordAfter')) {{ old('recordAfter') }} @else {{ $travel->recordAfter }} @endif"
                            placeholder="أدخل قراءة العدّاد بعد الرحلة">
                    </div> --}}
                    <!-- /.card-body -->
                </div>
                <div class="card-footer">
                    <button type="button" onclick="update({{ $travel->id }})" class="btn btn-primary">تعديل</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')

    <script>
        function update(id) {
            axios.put('/travels/' + id, {
                    sub_consumer_id: document.getElementById('sub_consumer_name').value,
                    road: document.getElementById('road').value,
                    cause: document.getElementById('cause').value,
                    // recordBefore: document.getElementById('recordBefore').value,
                    // recordAfter: document.getElementById('recordAfter').value,
                    date: document.getElementById('date').value
                })
                .then(function(response) {
                    window.location.href = '/travels/';
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
