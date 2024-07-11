@extends('parent')

@section('title', 'عرض المحتوى')

@section('header', 'عرض المحتوى')

@section('content')

    @if ($logFile->action == 'adding')
        <div class="card" style="width: 50%; margin: auto">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">البيانات</th>
                            <th class="text-center">القيمة</th>
                        </tr>
                    </thead>
                    <tbody>
                        <div class="d-none">
                            {{ $data = $logFile->object_type::find($logFile->object_id) }}
                        </div>
                        @foreach ($data->toArray() as $k => $v)
                            <tr>
                                <td class="text-center">{{ $k }}</td>
                                <td class="text-center">{{ $v }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @elseif ($logFile->action == 'editting')
        <div class="card" style="width: 50%; margin: auto">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">البيانات</th>
                            <th class="text-center">القيمة القديمة</th>
                            <th class="text-center">القيمة الجديدة</th>
                        </tr>
                    </thead>
                    <tbody>
                        <div class="d-none">
                            @php
                                $newData = $logFile->object_type::find($logFile->object_id);
                                $oldData = $logFile->old_content;
                                $oldArray = json_decode($oldData, true);
                                $newArray = $newData->toArray();
                            @endphp
                        </div>
                        @if (json_last_error() === JSON_ERROR_NONE)
                            @php
                                // Create a combined list of keys from both arrays
                                $keys = array_unique(array_merge(array_keys($oldArray), array_keys($newArray)));
                            @endphp
                            @foreach ($keys as $key)
                                <tr>
                                    <td class="text-center">{{ htmlspecialchars($key, ENT_QUOTES, 'UTF-8') }}</td>
                                    <td class="text-center">
                                        @if (isset($oldArray[$key]))
                                            @if (is_array($oldArray[$key]))
                                                <pre>{{ htmlspecialchars(json_encode($oldArray[$key], JSON_PRETTY_PRINT), ENT_QUOTES, 'UTF-8') }}</pre>
                                            @else
                                                {{ htmlspecialchars($oldArray[$key], ENT_QUOTES, 'UTF-8') }}
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if (isset($newArray[$key]))
                                            @if (is_array($newArray[$key]))
                                                <pre>{{ htmlspecialchars(json_encode($newArray[$key], JSON_PRETTY_PRINT), ENT_QUOTES, 'UTF-8') }}</pre>
                                            @else
                                                {{ htmlspecialchars($newArray[$key], ENT_QUOTES, 'UTF-8') }}
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" class="text-center">Invalid JSON data.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    @elseif ($logFile->action == 'deleting')
        <div class="card" style="width: 50%; margin: auto">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">البيانات</th>
                            <th class="text-center">القيمة</th>
                        </tr>
                    </thead>
                    <tbody>
                        <div class="d-none">
                            @php
                                $data = $logFile->old_content;
                                $array = json_decode($data, true);
                            @endphp
                        </div>
                        @if (json_last_error() === JSON_ERROR_NONE)
                            @foreach ($array as $k => $v)
                                <tr>
                                    <td class="text-center">{{ htmlspecialchars($k, ENT_QUOTES, 'UTF-8') }}</td>
                                    <td class="text-center">
                                        @if (is_array($v))
                                            <pre>{{ htmlspecialchars(json_encode($v, JSON_PRETTY_PRINT), ENT_QUOTES, 'UTF-8') }}</pre>
                                        @else
                                            {{ htmlspecialchars($v, ENT_QUOTES, 'UTF-8') }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="2" class="text-center">Invalid JSON data.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    @endif
@endsection
