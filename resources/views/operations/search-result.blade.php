@extends('parent')

@section('title', 'العمليات')
@if ($operations->first())
    @section('header', 'العمليات')
@endif
@section('content')

    @if (session()->has('messege'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <h5><i class="icon fas fa-check"></i> تأكيد !</h5>
            {{ session('messege') }}
        </div>
    @endif
    @if ($operations->first())
        <div class="d-none"> {{ $counter = 1 }}</div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title float-left mt-2">جدول العمليات</h3>
            </div>
            <div class="d-none">
                {{ $page = 'search' }}
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
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
                            <th style="width: 100px ; text-align: center">الإعدادات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($operations as $operation)
                            <div class="d-none">
                                {{ $va = App\Models\SubConsumer::where('id', $operation->sub_consumer_id)->first() }}
                            </div>
                            <tr>
                                <td>
                                    {{ $counter++ }}
                                </td>
                                @if ($va !== null)
                                    <td>
                                        {{ $va->details }}
                                    </td>
                                    <td>{{ App\Models\Consumer::where('id', $va->consumer_id)->first()->name }}</td>
                                    <td>{{ $operation->receiverName }}</td>
                                    <td style=" text-align: center">{{ $operation->type }}</td>
                                    <td
                                        style=" text-align: center; @if ($operation->checked) background-color: #ee6674 @endif">
                                        {{ $operation->dischangeNumber }}</td>
                                @else
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td style=" text-align: center">{{ $operation->type }}</td>
                                    <td
                                        style=" text-align: center; @if ($operation->checked) background-color: #ee6674 @endif">
                                        -</td>
                                @endif
                                <td style=" text-align: center">{{ $operation->foulType }}</td>
                                <td style=" text-align: center">{{ number_format($operation->amount, 2) }}</td>
                                <td style=" text-align: center">{{ $operation->new_date }}</td>

                                <td class="text-center align-middle">
                                    <div class="btn-group">
                                        @if ($operation->type == 'صرف')
                                            <a href="{{ route('operations.show-outcome', $operation->id) }}"
                                                class="btn btn-info"
                                                style="border-top-right-radius: 10px;border-bottom-right-radius: 10px"><i
                                                    class="fas fa-eye"></i></a>
                                            <a href="{{ route('operations.edit-outcome', [$operation->id, $page]) }}"
                                                class="btn btn-success"><i class="fas fa-edit"></i></a>
                                        @else
                                            <a href="{{ route('operations.show-income', $operation->id) }}"
                                                class="btn btn-info"
                                                style="border-top-right-radius: 10px;border-bottom-right-radius: 10px"><i
                                                    class="fas fa-eye"></i></a>
                                            <a href="{{ route('operations.edit-income', [$operation->id, $page]) }}"
                                                class="btn btn-success"><i class="fas fa-edit"></i></a>
                                        @endif

                                        <a href="#" onclick="confirmDestroy('{{ $operation->id }}' , this)"
                                            class="btn btn-danger"
                                            style="border-top-left-radius: 10px;border-bottom-left-radius: 10px"><i
                                                class="fas fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <a href="{{ route('operations.print') }}" target="_blank" class="btn btn-default"><i
                        class="fas fa-print"></i>
                    طباعة</a>
            </div>
        </div>
    @else
        <div class="text-center mt-5">

            <svg xmlns="http://www.w3.org/2000/svg" width="150px" height="150px" viewBox="0 0 16 16">
                <path
                    d="m 3 0 c -1.660156 0 -3 1.339844 -3 3 v 7 c 0 1.660156 1.339844 3 3 3 h 10 c 1.660156 0 3 -1.339844 3 -3 v -7 c 0 -1.660156 -1.339844 -3 -3 -3 z m 0 2 h 10 c 0.554688 0 1 0.445312 1 1 v 7 c 0 0.554688 -0.445312 1 -1 1 h -10 c -0.554688 0 -1 -0.445312 -1 -1 v -7 c 0 -0.554688 0.445312 -1 1 -1 z m 3 2 c -0.550781 0 -1 0.449219 -1 1 s 0.449219 1 1 1 s 1 -0.449219 1 -1 s -0.449219 -1 -1 -1 z m 4 0 c -0.550781 0 -1 0.449219 -1 1 s 0.449219 1 1 1 s 1 -0.449219 1 -1 s -0.449219 -1 -1 -1 z m -2 3 c -1.429688 0 -2.75 0.761719 -3.464844 2 c -0.136718 0.238281 -0.054687 0.546875 0.183594 0.683594 c 0.238281 0.136718 0.546875 0.054687 0.683594 -0.183594 c 0.535156 -0.929688 1.523437 -1.5 2.597656 -1.5 s 2.0625 0.570312 2.597656 1.5 c 0.136719 0.238281 0.445313 0.320312 0.683594 0.183594 c 0.238281 -0.136719 0.320312 -0.445313 0.183594 -0.683594 c -0.714844 -1.238281 -2.035156 -2 -3.464844 -2 z m -3 7 c -1.105469 0 -2 0.894531 -2 2 h 10 c 0 -1.105469 -0.894531 -2 -2 -2 z m 0 0"
                    fill="#2e3436" />
            </svg>
            <h2
                style="border: 5px solid #2e3436 ; color: #2e3436; border-radius: 20px; display: block; padding: 10px; width: 50% ; margin: auto">
                لا يوجد عمليات تتطابق مع هذا البحث
            </h2>
        </div>
    @endif

@endsection


@section('script')
    <script>
        function confirmDestroy(id, ref) {
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "سيتم حذف العملية",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'لا',
                confirmButtonText: 'نعم',
            }).then((result) => {
                if (result.isConfirmed) {
                    destroy(id, ref);
                }
            });
        }

        function destroy(id, ref) {
            axios.delete('/operations/' + id)
                .then(function(response) {
                    ref.closest('tr').remove();
                    showMessage(response.data)
                })
                .catch(function(error) {
                    showMessage(error.response.data)
                })
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
