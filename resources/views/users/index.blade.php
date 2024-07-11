@extends('parent')

@section('title', 'المستخدمين')

@section('header', 'المستخدمين')

@section('content')

    <div class="d-none">{{ $counter = 1 }}</div>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title float-none mt-2">جدول المستخدمين </h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>اسم المستخدم</th>
                            <th>الاسم</th>
                            <th style="width: 200px; text-align: center">الإعدادات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->name }}</td>
                                <td class="text-center align-middle">
                                    <div class="btn-group">
                                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-info"
                                            style="border-top-right-radius: 10px;border-bottom-right-radius: 10px"><i
                                                class="fas fa-eye"></i></a>
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-success"><i
                                                class="fas fa-edit"></i></a>
                                        <a href="#"
                                            onclick="confirmDestroy('{{ $user->username }}' , '{{ $user->id }}' , this)"
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
                text: "سيتم حذف المستخدم (" + name + ")",
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
            axios.delete('/users/' + id)
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
