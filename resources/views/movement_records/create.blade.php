@extends('parent')

@section('title', 'إضافة قراءة عدّاد')

@section('header', 'إضافة قراءة عدّاد')

@section('content')

    <div class="container">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title p-2"></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="form">
                @csrf
                <div class="card-body">

                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">المستهلك الرئيسي</span>
                                    <span
                                        class="info-box-number text-center text-muted mb-0">{{ $subConsumer->consumer->name }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">المستهلك</span>
                                    <span class="info-box-number text-center text-muted mb-0">{{ $subConsumer->details }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">قراءة العدّاد السابقة</span>
                                    <span class="info-box-number text-center text-muted mb-0">
                                        @if ($subConsumer->movementRecord)
                                            {{ number_format(+$subConsumer->movementRecord()->orderByDesc('date')->orderByDesc('created_at')->first()->record) }}
                                        @else
                                            لا يوجد
                                        @endif
                                        <span>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="record">قراءة العداد</label>
                                <input type="text" class="form-control" id="record" name="record"
                                    value="@if (old('record')) {{ old('record') }} @endif"
                                    placeholder="أدخل قراءة العدّاد">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="date">التاريخ</label>
                                <input type="date" class="form-control" id="date" name="date"
                                    @if (old('date')) value="{{ \Carbon\Carbon::parse(old('date'))->format('Y-m-d') }}" @else value="{{ \Carbon\Carbon::parse(now())->format('Y-m-d') }}" @endif
                                    placeholder="أدخل التاريخ">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="button" onclick="store({{ $subConsumer->id }})" class="btn btn-primary">إضافة</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')

    <script>
        function store(id) {
            console.log('test');
            axios.post('/movement_records/' + id, {
                    record: document.getElementById('record').value,
                    date: document.getElementById('date').value,
                    subConsumerId: id
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
