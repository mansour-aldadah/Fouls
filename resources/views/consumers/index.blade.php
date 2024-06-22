@extends('parent')

@section('title', 'المستهلكين الرئيسيين')

@section('header', 'المستهلكين الرئيسيين')

@section('content')

    <div class="d-none">{{ $counter = 1 }}</div>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title float-none mt-2">جدول المستهلكين الرئيسيين</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>المستهلك</th>
                            <th style="width: 200px; text-align: center">عدد المستهلكين الفرعيين</th>
                            <th style="width: 200px; text-align: center">عدد العمليات</th>
                            <th style="width: 200px; text-align: center">الإعدادات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($consumers as $consumer)
                            <tr>
                                <td class="d-none"> <input type="text" id="count"
                                        value="{{ $consumer->subConsumers()->count() }}">
                                </td>
                                <td>{{ $counter++ }}</td>
                                <td>{{ $consumer->name }}</td>
                                <td class="text-center align-middle">
                                    {{ $consumer->subConsumers()->count() }}</td>
                                <td class="text-center align-middle"> {{ $consumer->operations()->count() }}</td>
                                <td class="text-center align-middle">
                                    <div class="btn-group">
                                        <a href="{{ route('consumers.show', $consumer->id) }}" class="btn btn-info"
                                            style="border-top-right-radius: 10px;border-bottom-right-radius: 10px"><i
                                                class="fas fa-eye"></i></a>
                                        <a href="{{ route('consumers.edit', $consumer->id) }}" class="btn btn-success"><i
                                                class="fas fa-edit"></i></a>
                                        <a href="#"
                                            onclick="confirmDestroy('{{ $consumer->name }}' , '{{ $consumer->id }}' , this)"
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
        </div>
    </div>
@endsection



@section('script')
    <script>
        function confirmDestroy(name, id, ref) {
            if (ref.closest('tr').children[0].children[0].value != 0) {
                data = {
                    icon: 'warning',
                    message: 'لا يمكنك حذف هذا المستهلك الرئيسي لأنه يتضمن مستهلكين فرعيين'
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
            axios.delete('/consumers/' + id)
                .then(function(response) {
                    console.log(response.data);
                    ref.closest('tr').remove();
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
    </script>
@endsection
