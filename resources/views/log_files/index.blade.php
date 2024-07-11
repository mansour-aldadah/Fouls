@extends('parent')

@section('title', 'سجل العمليات')

@section('header', 'سجل العمليات')

@section('content')
    <div class="d-none">{{ $counter = 1 }}</div>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title float-none mt-2">سجل العمليات</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th style="width: 200px; text-align: center">المستخدم</th>
                            <th style="width: 200px; text-align: center">نوع العملية</th>
                            <th style="width: 200px; text-align: center">الجدول</th>
                            <th style="width: 200px; text-align: center">العملية</th>
                            <th style="width: 200px; text-align: center">المحتوى</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logFiles as $logFile)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td class="text-center align-middle">
                                    {{ App\Models\User::find($logFile->user_id)->username }}</td>
                                @if ($logFile->action == 'adding')
                                    <td class="text-center align-middle text-success">إضافة</td>
                                @elseif($logFile->action == 'editting')
                                    <td class="text-center align-middle text-info">تعديل</td>
                                @else
                                    <td class="text-center align-middle text-danger">حذف</td>
                                @endif

                                @if ($logFile->object_type == 'App\Models\Travel')
                                    <td class="text-center align-middle">رحلة</td>
                                @elseif($logFile->object_type == 'App\Models\Consumer')
                                    <td class="text-center align-middle">مستهلك</td>
                                @elseif($logFile->object_type == 'App\Models\SubConsumer')
                                    <td class="text-center align-middle">مستهلك فرعي</td>
                                @elseif($logFile->object_type == 'App\Models\MovementRecord')
                                    <td class="text-center align-middle">قراءة عدّاد</td>
                                @elseif($logFile->object_type == 'App\Models\Operation')
                                    <td class="text-center align-middle">عملية</td>
                                @elseif($logFile->object_type == 'App\Models\User')
                                    <td class="text-center align-middle">مستخدم</td>
                                @endif

                                <td class="text-center align-middle">{{ $logFile->object_id }}</td>

                                <td class="text-center align-middle">
                                    <div class="btn-group">
                                        <a href="{{ route('log_files.show', $logFile->id) }}" class="btn btn-info"
                                            style="border-radius: 10px"><i class="fas fa-eye"></i></a>
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
