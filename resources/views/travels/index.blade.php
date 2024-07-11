@extends('parent')

@section('title', 'الرحلات')

@section('header', 'الرحلات')

@section('content')
    <div class="d-none">{{ $counter = 1 }}</div>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title float-none mt-2">جدول الرحلات </h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>اسم المستهلك</th>
                            <th>وجهة الرحلة</th>
                            <th>سبب الرحلة</th>
                            <th style="text-align:center">تاريخ الرحلة</th>
                            <th style="text-align:center">المسافة المقطوعة</th>
                            @if (Illuminate\Support\Facades\Auth::user()->role == 'مستهلك')
                                <th style="text-align: center">خيارات</th>
                                <th style="width: 200px; text-align: center">الإعدادات</th>
                            @else
                                <th style="text-align: center">الحالة</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($travels as $travel)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td>{{ $travel->subConsumer->details }}</td>
                                <td>{{ $travel->road }}</td>
                                <td>{{ $travel->cause }}</td>
                                <td style="text-align:center">{{ $travel->date }}</td>
                                <td style="text-align:center">
                                    @if ($travel->status == 'منتهية')
                                        {{ number_format(+$travel->recordAfter - +$travel->recordBefore) }} كيلو متر
                                    @elseif($travel->status == 'ملغية')
                                        ألغيت
                                    @else
                                        لم تنته بعد
                                    @endif
                                </td>
                                @if (Illuminate\Support\Facades\Auth::user()->role == 'مستهلك')
                                    @if ($travel->status == 'منشأة')
                                        <td style="text-align:center"><a href="#"
                                                onclick="start({{ $travel->id }} , this)" class="btn btn-success"
                                                style="border-radius: 10px"> بدء الرحلة</a>
                                        </td>
                                    @elseif($travel->status == 'قيد التنفيذ')
                                        <td style="text-align:center"><a href="#"
                                                onclick="end({{ $travel->id }} , this)" class="btn btn-danger"
                                                style="border-radius: 10px"> إنهاء الرحلة</a>
                                        </td>
                                    @elseif($travel->status == 'منتهية')
                                        <td style="text-align:center">
                                            <span class="text">منتهية</span>
                                        </td>
                                    @elseif($travel->status == 'ملغية')
                                        <td style="text-align:center">
                                            <span class="text-danger">ملغية</span>
                                        </td>
                                    @endif
                                    @if ($travel->status == 'منشأة')
                                        <td class="text-center align-middle">
                                            <div class="btn-group">
                                                <a href="{{ route('travels.edit', $travel->id) }}" class="btn btn-success"
                                                    style="border-top-right-radius: 10px;border-bottom-right-radius: 10px"><i
                                                        class="fas fa-edit"></i></a>
                                                <a href="#"
                                                    onclick="confirmDestroy('{{ $travel->road }}' , '{{ $travel->id }}' , this)"
                                                    class="btn btn-danger"
                                                    style="border-top-left-radius: 10px;border-bottom-left-radius: 10px"><i
                                                        class="fas fa-trash"></i></a>
                                            </div>
                                        </td>
                                    @else
                                        <td class="text-center align-middle">
                                            ---
                                        </td>
                                    @endif
                                @else
                                    <td style="text-align:center">{{ $travel->status }}</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script>
        function confirmDestroy(name, id, ref) {
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "سيتم إلغاء الرحلة (" + name + ")",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'لا',
                confirmButtonText: 'نعم',
            }).then((result) => {
                if (result.isConfirmed) {
                    destroy(name, id, ref);
                }
            });
        }

        function destroy(name, id, ref) {
            axios.put('/travels/cancelTravel/' + id)
                .then(function(response) {
                    console.log(response.data);
                    // ref.closest('tr').remove();
                    showMessage(response.data)
                })
                .catch(function(error) {
                    showMessage(error.response.data)
                })
        }

        function showMessage(data) {
            console.log(data);
            Swal.fire({
                toast: true,
                icon: data.icon,
                title: data.message,
                showConfirmButton: false,
                position: 'top-start',
                timer: 3000
            });
        }

        function start(id, ref) {
            Swal.fire({
                title: "أدخل قراءة العدّاد",
                input: "text",
                inputAttributes: {
                    autocapitalize: "off"
                },
                showCancelButton: true,
                cancelButtonText: 'إلغاء',
                confirmButtonText: "بدء",
                showLoaderOnConfirm: true,
                preConfirm: (reading) => {
                    if (!reading) {
                        Swal.showValidationMessage(`أدخل قراءة العدّاد قبل الرحلة`);
                    }
                    return reading;
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    startTravel(id, result.value, ref);
                }
            });
        }

        function end(id, ref) {
            Swal.fire({
                title: "أدخل قراءة العدّاد",
                input: "text",
                inputAttributes: {
                    autocapitalize: "off"
                },
                showCancelButton: true,
                cancelButtonText: 'إلغاء',
                confirmButtonText: 'إنهاء',
                showLoaderOnConfirm: true,
                preConfirm: (reading) => {
                    if (!reading) {
                        Swal.showValidationMessage(`أدخل قراءة العدّاد بعد الرحلة`);
                    }
                    return reading;
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    endTravel(id, result.value, ref);
                }
            });
        }

        function startTravel(id, reading, ref) {
            axios.put('/travels/updateStatus/' + id, {
                    reading: reading
                })
                .then(function(response) {
                    if (response.data.icon === 'success') {
                        ref.classList.remove('btn-success');
                        ref.classList.add('btn-danger');
                        ref.textContent = 'إنهاء الرحلة';
                    }
                    showMessage(response.data);
                })
                .catch(function(error) {
                    showMessage(error.response.data);
                });
        }

        function endTravel(id, reading, ref) {
            axios.put('/travels/updateStatus/' + id, {
                    reading: reading
                })
                .then(function(response) {
                    if (response.data.icon === 'success') {
                        ref.outerHTML = '<span class="text-danger">منتهية</span>';
                    }
                    showMessage(response.data);
                })
                .catch(function(error) {
                    showMessage(error.response.data);
                });
        }
    </script>
@endsection
