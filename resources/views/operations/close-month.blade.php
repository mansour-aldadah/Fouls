@extends('parent')

@section('title', 'إغلاق شهر')

@section('header', 'إغلاق شهر')

@section('content')
    <div class="d-none"> {{ $counter = 1 }}</div>
    <div class="card">
        <div class="card-header">
            <form id="form">
                @csrf
                <div class="form-group">
                    <label>إغلاق عمليات شهر:</label>
                    <select class="form-control select2" style="width: 100%;" id="month" name="month"
                        onchange="filterOperations()">
                        <option value="">اختر الشهر</option>
                        @foreach ($months as $month)
                            <option value="{{ $month }}">{{ $month }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
        <div class="d-none">
            {{ $page = 'index' }}
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="operations-table">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>المستهلك</th>
                        <th>المستهلك الأساسي</th>
                        <th> اسم المستلم</th>
                        <th style="width: 70px ; text-align: center">النوع</th>
                        <th style="width: 110px ; text-align: center">سند الصرف</th>
                        <th style="width: 100px ; text-align: center">نوع الوقود</th>
                        <th style="width: 70px ; text-align: center">الكمية</th>
                        <th style="width: 120px ; text-align: center">التاريخ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($operations as $operation)
                        <tr class="operation-row"
                            data-month="{{ \Carbon\Carbon::parse($operation->new_date)->format('Y-m') }}">
                            <td>{{ $counter++ }}</td>
                            <td>{{ optional($operation->subConsumer)->details ?? '-' }}</td>
                            <td>{{ optional($operation->subConsumer)->consumer->name ?? '-' }}</td>
                            <td>{{ $operation->receiverName }}</td>
                            <td style="text-align: center">{{ $operation->type }}</td>
                            <td
                                style="text-align: center; @if ($operation->checked) background-color: #ee6674 @endif">
                                {{ $operation->dischangeNumber ?? '-' }}</td>
                            <td style="text-align: center">{{ $operation->foulType }}</td>
                            <td style="text-align: center">{{ number_format($operation->amount, 2) }}</td>
                            <td style="text-align: center">{{ $operation->new_date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer" id="footer" style="display: none;">
            <button type="button" onclick="confirmUpdate()" class="btn btn-primary">إغلاق</button>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function filterOperations() {
            const selectedMonth = document.getElementById('month').value;
            const operationRows = document.querySelectorAll('.operation-row');
            const footer = document.getElementById('footer');

            operationRows.forEach(row => {
                if (selectedMonth === '' || row.getAttribute('data-month') === selectedMonth) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            // Show or hide the footer based on whether a month is selected
            if (selectedMonth === '') {
                footer.style.display = 'none';
            } else {
                footer.style.display = 'block';
            }
        }


        function confirmUpdate() {
            const selectedMonth = document.getElementById('month').value;
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "سيتم إغلاق شهر " + selectedMonth,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'لا',
                confirmButtonText: 'نعم',
            }).then((result) => {
                if (result.isConfirmed) {
                    update();
                }
            });
        }

        function update() {
            axios.put('/operations/close-month/', {
                    month: document.getElementById('month').value
                })
                .then(function(response) {
                    window.location.href = '/dashboard';
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
