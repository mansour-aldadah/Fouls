@extends('parent')

@section('title', 'تعديل قراءة عدّاد')

@section('header', 'تعديل قراءة عدّاد')

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
                                    <span class="info-box-text text-center text-muted">قراءة العدّاد الأخيرة</span>
                                    <span class="info-box-number text-center text-muted mb-0">
                                        @if ($subConsumer->movementRecords()->first())
                                            {{ number_format(+$subConsumer->movementRecords()->orderByDesc('date')->orderByDesc('created_at')->first()->record) }}
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
                                    value="@if (old('record')) {{ old('record') }} @else {{ $movementRecord->record }} @endif"
                                    placeholder="أدخل قراءة العدّاد">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="date">التاريخ</label>
                                <input type="date" class="form-control" id="date" name="date"
                                    @if (old('date')) value="{{ \Carbon\Carbon::parse(old('date'))->format('Y-m-d') }}" @else value="{{ $movementRecord->date }}" @endif
                                    placeholder="أدخل التاريخ">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="button"
                        onclick="update({{ $movementRecord->id }} , {{ $movementRecord->sub_consumer_id }})"
                        class="btn btn-primary">تعديل</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')

    <script>
        function update(id, id2) {
            console.log('test');
            axios.put('/movement_records/' + id, {
                    record: document.getElementById('record').value,
                    date: document.getElementById('date').value,
                    subConsumerId: id2
                })
                .then(function(response) {
                    window.location.href = '/sub_consumers/' + id2;
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
