@extends('parent')

@section('title', 'العمليات الواردة')

@section('header', 'العمليات الواردة')

@section('content')

    @if (session()->has('messege'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <h5><i class="icon fas fa-check"></i> تأكيد !</h5>
            {{ session('messege') }}
        </div>
    @endif
    <div class="d-none"> {{ $counter = 1 }}</div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title float-left mt-2"> جدول العمليات الواردة</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px; text-align: center">#</th>
                        <th style="width: 200px ; text-align: center">النوع</th>
                        <th style="width: 200px ; text-align: center">نوع الوقود</th>
                        <th style="width: 200px ; text-align: center">الكمية</th>
                        <th style="text-align: center">التاريخ</th>
                        <th style="text-align: center">الإعدادات</th>
                    </tr>
                </thead>
                <tbody>
                    <div class="d-none">
                        {{ $page = 'index-income' }}
                    </div>
                    @foreach ($operations as $operation)
                        <tr>
                            <td>
                                {{ $counter++ }}.
                            </td>
                            <td style=" text-align: center">{{ $operation->type }}</td>
                            <td style=" text-align: center">{{ $operation->foulType }}</td>
                            <td style=" text-align: center">{{ number_format($operation->amount) }}</td>
                            <td style=" text-align: center">{{ $operation->new_date }}</td>

                            <td class="text-center align-middle">
                                <div class="btn-group">
                                    <a href="{{ route('operations.show-income', $operation->id) }}" class="btn btn-info"
                                        style="border-top-right-radius: 10px;border-bottom-right-radius: 10px"><i
                                            class="fas fa-eye"></i></a>
                                    <a href="{{ route('operations.edit-income', [$operation->id, $page]) }}"
                                        class="btn btn-success"><i class="fas fa-edit"></i></a>
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
        <div class="card-footer d-none">
        </div>
    </div>
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
