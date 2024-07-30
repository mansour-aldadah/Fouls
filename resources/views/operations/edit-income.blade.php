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
            <form role="form" method="POST"
                action="{{ route('operations.update-income', [$operation->id, 'page' => $page]) }}">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
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
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="amount">الكمية</label>
                                <input type="text" class="form-control" id="amount" name="amount"
                                    value="@if (old('amount')) {{ old('amount') }} @else {{ $operation->amount }} @endif"
                                    placeholder="أدخل كمية الوقود">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="date">التاريخ</label>
                                <input type="datetime-local" class="form-control" id="date" name="date" readonly
                                    @if (old('date')) value="{{ \Carbon\Carbon::parse(old('date')) }}" @else
                                value="{{ $operation->date }}" @endif
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
