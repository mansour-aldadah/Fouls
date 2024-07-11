@extends('parent')

@section('title', 'تعديل عملية')

@section('header', 'تعديل عملية')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <button class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <h5><i class="icon fas fa-ban"></i> تحذير !</h5>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
    @endif

    <div class="container">

        <div class="card card-primary">
            <div class="card-header ">
                <h3 class="card-title p-2"></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            {{-- {{ dd($page) }} --}}
            <form role="form" method="POST" action="{{ route('operations.update', [$operation->id, 'page' => $page]) }}">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <!-- text input -->
                            <div class="form-group" data-select2-id="13">
                                <label>المستهلك الرئيسي</label>
                                <select class="form-control select2 select2-hidden-accessible consumer_name"
                                    id="consumer_name" name="consumer_name" style="width: 100%;" data-select2-id="1"
                                    tabindex="-1" aria-hidden="true">
                                    <option value="{{ $consumer->id }}">{{ $consumer->name }}</option>
                                    {{ $consumer_id = App\Models\SubConsumer::withTrashed()->findOrFail($operation->sub_consumer_id)->consumer_id }}
                                    {{-- {{ dd(App\Models\Consumer::findOrFail($consumer_id)->subConsumers) }} --}}
                                    @foreach ($consumers as $cons)
                                        <option value="{{ $cons->id }}"
                                            @if ($consumer_id == $cons->id) selected @endif>
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
                                    <option value="{{ $subConsumer->id }}">{{ $subConsumer->details }}</option>
                                    @foreach (App\Models\Consumer::withTrashed()->findOrFail($consumer_id)->subConsumers as $subConsumer)
                                        <option value="{{ $subConsumer->id }}"
                                            @if ($subConsumer->id == $operation->sub_consumer_id) selected @endif>{{ $subConsumer->details }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="receiverName">اسم المستلم</label>
                                <input type="string" class="form-control" id="receiverName"
                                    name="receiverName"value="@if (old('receiverName')) {{ old('receiverName') }} @else {{ $operation->receiverName }} @endif"
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
                                    @if (old('foulType'))
                                        <option value="بنزين" @if (old('foulType') == 'بنزين') selected @endif> بنزين
                                        </option>
                                        <option value="سولار"@if (old('foulType') == 'سولار') selected @endif> سولار
                                        </option>
                                    @else
                                        <option value="بنزين" @if ($operation->foulType == 'بنزين') selected @endif> بنزين
                                        </option>
                                        <option value="سولار"@if ($operation->foulType == 'سولار') selected @endif> سولار
                                        </option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="dischangeNumber">رقم سند الصرف</label>
                                <input type="string" class="form-control" id="dischangeNumber" name="dischangeNumber"
                                    value="@if (old('dischangeNumber')) {{ old('dischangeNumber') }} @else {{ $operation->dischangeNumber }} @endif"
                                    placeholder="أدخل رقم سند الصرف">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="amount">الكمية</label>
                                <input type="text" class="form-control" id="amount" name="amount"
                                    value="@if (old('amount')) {{ old('amount') }} @else {{ $operation->amount }} @endif"
                                    placeholder="أدخل كمية الوقود">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="date">التاريخ</label>
                                <input type="date" class="form-control" id="date" name="date"
                                    @if (old('date')) value="{{ \Carbon\Carbon::parse(old('date'))->format('Y-m-d') }}"  @else
                                value="{{ $operation->new_date }}" @endif
                                    placeholder="أدخل التاريخ">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch1" name="checked"
                                @if (old('checked')) checked @elseif($operation->checked) checked @endif>
                            <label class="custom-control-label" for="customSwitch1">تحت المراجعة</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>وصف</label>
                        <textarea class="form-control" name="description" rows="3"
                            @if (old('description')) value="{{ old('description') }}" @else vlaue="{{ $operation->description }}" @endif
                            placeholder="أدخل ...">{{ $operation->description }}</textarea>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">تعديل</button>
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
        });
    </script>

@endsection
