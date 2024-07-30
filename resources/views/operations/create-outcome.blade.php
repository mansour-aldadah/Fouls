@extends('parent')

@section('title', 'إنشاء عملية صرف جديدة')

@section('header', 'إنشاء عملية صرف جديدة')

@section('content')

    <div class="container">

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button class="close" data-dismiss="alert" aria-hidden="true">x</button>
                <h5><i class="icon fas fa-ban"></i> تحذير !</h5>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        @endif

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title p-2"></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" method="POST" action="{{ route('operations.store') }}">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <!-- text input -->
                            <div class="form-group" data-select2-id="13">
                                <label>المستهلك الرئيسي</label>
                                <select class="form-control select2 select2-hidden-accessible consumer_name"
                                    id="consumer_name" name="consumer_name" style="width: 100%;" data-select2-id="1"
                                    tabindex="-1" aria-hidden="true">
                                    <option value="">اختر المستهلك الرئيسي</option>
                                    @foreach ($consumers as $cons)
                                        <option value="{{ $cons->id }}"
                                            @if (old('consumer_name') == $cons->id) selected @endif>
                                            {{ $cons->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group" data-select2-id="13">
                                <label>المستهلك</label>
                                <select class="form-control select2 select2-hidden-accessible" id="sub_consumer_name"
                                    name="sub_consumer_name" style="width: 100%;" data-select2-id="1" tabindex="-1"
                                    aria-hidden="true">
                                    <option value="">اختر المستهلك الفرعي</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="receiverName">اسم المستلم</label>
                                <input type="string" class="form-control" id="receiverName"
                                    name="receiverName"value="@if (old('receiverName')) {{ old('receiverName') }} @endif"
                                    placeholder="أدخل اسم المستلم">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group" data-select2-id="13">
                                <label>نوع الوقود</label>
                                <select class="form-control select2 select2-hidden-accessible" id="foulType"
                                    name="foulType" style="width: 100%;" data-select2-id="1" tabindex="-1"
                                    aria-hidden="true">
                                    <option value="بنزين" @if (old('foulType') == 'بنزين') selected @endif> بنزين
                                    </option>
                                    <option value="سولار"@if (old('foulType') == 'سولار') selected @endif> سولار
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="dischangeNumber">رقم سند الصرف</label>
                                <input type="string" class="form-control" id="dischangeNumber"
                                    name="dischangeNumber"value="@if (old('dischangeNumber')) {{ old('dischangeNumber') }} @endif"
                                    placeholder="أدخل رقم سند الصرف">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="amount">الكمية</label>
                                <input type="text" class="form-control" id="amount" name="amount"
                                    value="@if (old('amount')) {{ old('amount') }} @endif"
                                    placeholder="أدخل كمية الوقود">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="date">التاريخ</label>
                                <input type="datetime-local" class="form-control" id="date" name="date"
                                    @if (old('date')) value="{{ \Carbon\Carbon::parse(old('date')) }}" @else value="{{ \Carbon\Carbon::parse(now(3)) }}" @endif
                                    placeholder="أدخل التاريخ">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch1" name="checked"
                                @if (old('checked')) checked @endif>
                            <label class="custom-control-label" for="customSwitch1">تحت المراجعة</label>
                        </div>
                    </div>
                    <div class="form-group" id="record-group" style="display:none;">
                        <label for="record">قراءة العدّاد الحالية</label>
                        <input type="text" class="form-control" id="record" name="record"
                            value="@if (old('record')) {{ old('record') }} @endif"
                            placeholder="أدخل قراءة العدّاد الحالية">
                    </div>
                    <div class="form-group">
                        <label>وصف</label>
                        <textarea class="form-control" name="description" rows="3"
                            value="@if (old('description')) {{ old('description') }} @endif" placeholder="أدخل ..."></textarea>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">إنشاء</button>
                </div>
            </form>
        </div>
    </div>
@endsection


@section('script')

    <script>
        $(document).ready(function() {
            $('#consumer_name').on('change', function() {
                var categoryId = $(this).val();
                $('#sub_consumer_name').empty();

                if (categoryId) {
                    $.ajax({
                        url: '/operations/create-outcome/' + categoryId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#sub_consumer_name').append(
                                '<option value="">اختر المستهلك الفرعي</option>');
                            $.each(data, function(key, value) {
                                $('#sub_consumer_name').append('<option value="' + value
                                    .id + '">' + value.details + '</option>');
                            });
                        }
                    });
                } else {
                    $('#sub_consumer_name').empty();
                    $('#sub_consumer_name').append('<option value="">اختر المستهلك الفرعي</option>');
                }
            });

            $('#sub_consumer_name').on('change', function() {
                var subConsumerId = $(this).val();

                if (subConsumerId) {
                    console.log('test');
                    $.ajax({
                        url: '/operations/check-has-record/' + subConsumerId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.hasRecord) {
                                $('#record-group').show();
                            } else {
                                $('#record-group').hide();
                            }
                        }
                    });
                } else {
                    $('#record-group').hide();
                }
            });
        });
    </script>

@endsection
