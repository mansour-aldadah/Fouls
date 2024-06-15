@extends('parent')

@section('title', 'بحث')

@section('header', 'بحث')

@section('content')

    <div class="container">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title p-2"></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" method="get" action="{{ route('operations.search-result') }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group" data-select2-id="13">
                                <label>النوع</label>
                                <select class="form-control select2 select2-hidden-accessible" id="type" name="type"
                                    style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                    <option value="">اختر النوع
                                    </option>
                                    <option value="وارد"> وارد
                                    </option>
                                    <option value="صرف"> صرف
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group" data-select2-id="13">
                                <label>نوع الوقود</label>
                                <select class="form-control select2 select2-hidden-accessible" id="foulType"
                                    name="foulType" style="width: 100%;" data-select2-id="1" tabindex="-1"
                                    aria-hidden="true">
                                    <option value="">اختر نوع الوقود
                                    </option>
                                    <option value="بنزين"> بنزين
                                    </option>
                                    <option value="سولار"> سولار
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group" data-select2-id="13">
                                <label>نوع التقرير</label>
                                <select class="form-control select2 select2-hidden-accessible" id="reportDate"
                                    name="reportDate" style="width: 100%;" data-select2-id="1" tabindex="-1"
                                    aria-hidden="true">
                                    <option value="">اختر نوع التقرير
                                    </option>
                                    <option value="يومي"> تقرير يومي
                                    </option>
                                    <option value="لفترة"> تقرير لفترة
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 typeDetails">
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
                        <div class="col-sm-3 typeDetails">
                            <div class="form-group" data-select2-id="13">
                                <label>المستهلك</label>
                                <select class="form-control select2 select2-hidden-accessible" id="sub_consumer_name"
                                    name="sub_consumer_name" style="width: 100%;" data-select2-id="1" tabindex="-1"
                                    aria-hidden="true">
                                    <option value="">اختر المستهلك الفرعي</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3 typeDetails">
                            <div class="form-group">
                                <label for="receiverName">اسم المستلم</label>
                                <input type="string" class="form-control" id="receiverName" name="receiverName"
                                    placeholder="أدخل اسم المستلم">
                            </div>
                        </div>
                        <div class="col-sm-3 typeDetails">
                            <div class="form-group ">
                                <label for="dischangeNumber">رقم سند الصرف</label>
                                <input type="string" class="form-control" id="dischangeNumber" name="dischangeNumber"
                                    placeholder="أدخل رقم سند الصرف">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="date" class="reportDate">من تاريخ</label>
                                <label for="date" class="onlyDate" style="display: none">التاريخ</label>
                                <input type="date" class="form-control" id="from_date" name="from_date"
                                    placeholder="أدخل التاريخ">
                            </div>
                        </div>
                        <div class="col-sm-6 reportDate">
                            <div class="form-group">
                                <label for="date">إلى تاريخ</label>
                                <input type="date" class="form-control" id="to_date" name="to_date"
                                    placeholder="أدخل التاريخ">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch1" name="checked">
                            <label class="custom-control-label" for="customSwitch1">تحت المراجعة</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>وصف</label>
                        <textarea class="form-control" name="description" rows="3" placeholder="أدخل ..."></textarea>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">بحث</button>
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
                                    .id +
                                    '">' + value.details + '</option>');
                            });
                        }
                    });
                } else {
                    $('#sub_consumer_name').empty();
                    $('#sub_consumer_name').append('<option value="">اختر المستهلك الفرعي</option>');
                }
            });

            $('#type').on('change', function() {
                var type = $(this).val();
                if (type) {
                    if (type == 'وارد') {
                        $('.typeDetails').css('display', 'none');
                    } else {
                        $('.typeDetails').css('display', 'block');
                    }
                } else {
                    $('.typeDetails').css('display', 'block');
                }
            })

            $('#reportDate').on('change', function() {
                var date = $(this).val();
                if (date) {
                    if (date == 'يومي') {
                        $('.reportDate').css('display', 'none');
                        $('.onlyDate').css('display', 'block');
                        $('#from_date').attr('required', 'required');
                    } else {
                        $('.reportDate').css('display', 'block');
                        $('.onlyDate').css('display', 'none');
                        $('#from_date').val("")
                    }
                } else {
                    $('.reportDate').css('display', 'block');
                    $('.onlyDate').css('display', 'none');
                    $('#from_date').val("")
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
