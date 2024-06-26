@extends('parent')

@section('title', 'إنشاء مستهلك فرعي')

@section('header', 'إنشاء مستهلك فرعي')

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
                        <label>المستهلك الرئيسي</label>
                        <select class="form-control select2 select2-hidden-accessible" id="consumer_id" name="consumer_id"
                            style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                            @foreach ($consumers as $cons)
                                <option value="{{ $cons->id }}" @if ($consumer == $cons) selected @endif>
                                    {{ $cons->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="details">اسم المستهلك</label>
                        <input type="text" class="form-control" id="details" name="details"
                            value="@if (old('details')) {{ old('details') }} @endif"
                            placeholder="أدخل اسم المستهلك">
                    </div>
                    <div class="form-group">
                        <label for="description">تفاصيل المستهلك</label>
                        <input type="text" class="form-control" id="description" name="description"
                            value="@if (old('description')) {{ old('description') }} @endif"
                            placeholder="أدخل تفاصيل المستهلك">
                    </div>
                    <!-- checkbox -->
                    <div class="form-group mt-4">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="hasRecord" name="hasRecord"
                                value="1" @if (old('hasRecord')) checked @endif>
                            <label for="hasRecord" class="custom-control-label">له عداد</label>
                        </div>
                    </div>
                    <div class="row" id="recordGroup" style="display: none">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="record">القراءة الأولية</label>
                                <input type="text" class="form-control" id="record" name="record"
                                    value="@if (old('record')) {{ old('record') }} @endif"
                                    placeholder="القراءة الأولية">
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
                    <button type="button" onclick="store()" class="btn btn-primary">إنشاء</button>
                </div>
            </form>
        </div>
    </div>

@endsection


@section('script')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hasRecordCheckbox = document.getElementById('hasRecord');
            const recordGroup = document.getElementById('recordGroup');

            function toggleRecordInput() {
                if (hasRecordCheckbox.checked) {
                    recordGroup.style.display = 'flex';
                } else {
                    recordGroup.style.display = 'none';
                }
            }

            // Set initial state
            toggleRecordInput();

            // Add event listener to checkbox
            hasRecordCheckbox.addEventListener('change', toggleRecordInput);
        });

        function store() {
            console.log('test');
            axios.post('/sub_consumers', {
                    consumer_id: document.getElementById('consumer_id').value,
                    details: document.getElementById('details').value,
                    description: document.getElementById('description').value,
                    record: document.getElementById('record').value,
                    date: document.getElementById('date').value,
                    hasRecord: document.getElementById('hasRecord').checked
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
