@extends('parent')

@section('title', 'المستهلكين الفرعيين')

@section('header', 'المستهلكين الفرعيين')

@section('content')

    @if (session()->has('messege'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <h5><i class="icon fas fa-check"></i> تأكيد !</h5>
            {{ session('messege') }}
        </div>
    @endif
    <div class="d-none">{{ $counter = 1 }}</div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title float-none">جدول المستهلكين الفرعيين</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>المستهلك</th>
                        <th>المستهلك الرئيسي</th>
                        <th>وصف</th>
                        <th style="width: 200px; text-align: center">عدد عمليات الصرف</th>
                        <th style="width: 200px; text-align: center">الإعدادات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subConsumers as $subConsumer)
                        <tr>
                            <td>{{ $counter++ }}.</td>
                            <td>{{ $subConsumer->details }}</td>
                            <td>{{ $subConsumer->consumer()->first()->name }}</td>
                            @if ($subConsumer->description)
                                <td>{{ $subConsumer->description }}</td>
                            @else
                                <td>-</td>
                            @endif
                            <td class="text-center align-middle">{{ $subConsumer->operations()->count() }}</td>

                            <td class="text-center align-middle">
                                <div class="btn-group">
                                    <a href="{{ route('sub_consumers.show', $subConsumer->id) }}" class="btn btn-info"
                                        style="border-top-right-radius: 10px;border-bottom-right-radius: 10px;"><i
                                            class="fas fa-eye"></i></a>
                                    <a href="{{ route('sub_consumers.edit', $subConsumer->id) }}" class="btn btn-success"><i
                                            class="fas fa-edit"></i></a>
                                    @if ($subConsumer->hasRecord)
                                        <a href="{{ route('movement_records.create', $subConsumer->id) }}"
                                            class="btn btn-secondary"><i class="nav-icon fas fa-tachometer-alt"></i></a>
                                    @endif
                                    <a href="#"
                                        onclick="confirmDestroy('{{ $subConsumer->details }}' , '{{ $subConsumer->id }}' , this)"
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
        <div class="card-footer clearfix">
        </div>
    </div>
@endsection


@section('script')
    <script>
        function confirmDestroy(name, id, ref) {
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "سيتم حذف المستهلك (" + name + ")",
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
            axios.delete('/sub_consumers/' + id)
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
