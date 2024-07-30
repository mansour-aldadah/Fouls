@extends('parent')

@section('title', 'إنشاء عملية استيراد جديدة')

@section('header', 'إنشاء عملية استيراد جديدة')

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
            <form role="form" method="POST" action="{{ route('operations.store-income') }}">
                @csrf

                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
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
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="amount">الكمية</label>
                                <input type="text" class="form-control" id="amount" name="amount"
                                    value="@if (old('amount')) {{ old('amount') }} @endif"
                                    placeholder="أدخل كمية الوقود">
                            </div>
                        </div>
                        <div class="col-sm-4">
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
