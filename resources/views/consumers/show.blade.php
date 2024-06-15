@extends('parent')

@section('title', $consumer->name)

@section('header', $consumer->name)

@section('content')

    <div class="d-none">{{ $counter = 1 }}</div>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title float-none mt-2">جدول {{ $consumer->name }}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>المستهلك الفرعي</th>
                            <th style="width: 300px; text-align: center">وصف إضافي</th>
                            <th style="width: 200px; text-align: center">عدد عمليات الصرف</th>
                            <th style="width: 200px; text-align: center">الإعدادات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sub_consumers as $sub_consumer)
                            <tr>
                                <td class="d-none"> <input type="text" id="count"
                                        value="{{ $sub_consumer->operations()->count() }}">
                                </td>
                                <td>{{ $counter++ }}</td>
                                <td>{{ $sub_consumer->details }}</td>
                                @if ($sub_consumer->description)
                                    <td>{{ $sub_consumer->description }}</td>
                                @else
                                    <td style="width: 200px; text-align: center">-</td>
                                @endif
                                <td class="text-center align-middle">{{ $sub_consumer->operations()->count() }}</td>
                                <td class="text-center align-middle">
                                    <div class="btn-group">
                                        <a href="{{ route('sub_consumers.show', $sub_consumer->id) }}" class="btn btn-info"
                                            style="border-top-right-radius: 10px;border-bottom-right-radius: 10px;"><i
                                                class="fas fa-eye"></i></a>
                                        <a href="{{ route('sub_consumers.edit', $sub_consumer->id) }}"
                                            class="btn btn-success"><i class="fas fa-edit"></i></a>
                                        @if ($sub_consumer->hasRecord)
                                            <a href="{{ route('movement_records.create', $sub_consumer->id) }}"
                                                class="btn btn-warning"><i class="nav-icon fas fa-tachometer-alt"></i></a>
                                        @endif
                                        <a href="#"
                                            onclick="confirmDestroy('{{ $sub_consumer->details }}' , '{{ $sub_consumer->id }}' , this)"
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
            <div class="card-footer clearfix">
                <div>
                    <a href="{{ route('sub_consumers.create', $consumer) }}" class="btn btn-block btn-primary">
                        <b>إضافة</b></a>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        function confirmDestroy(name, id, ref) {
            if (ref.closest('tr').children[0].children[0].value != 0) {
                data = {
                    icon: 'warning',
                    message: 'لا يمكنك حذف هذا المستهلك لأنه يتضمن بعض العمليات'
                };
                showMessage(data);
            } else {
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
