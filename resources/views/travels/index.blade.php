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
                            <th>طريق الرحلة</th>
                            <th>هدف الرحلة</th>
                            <th style="width: 200px; text-align: center">الإعدادات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($travels as $travel)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td>{{ $travel->subConsumer->details }}</td>
                                <td>{{ $travel->road }}</td>
                                <td>{{ $travel->cause }}</td>
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
                text: "سيتم حذف الرحلة (" + name + ")",
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
            axios.delete('/travels/' + id)
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
