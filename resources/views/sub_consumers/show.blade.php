@extends('parent')

@section('title', 'المستهلك ' . "($subConsumer->details)")

@section('header', 'المستهلك ' . '(' . $subConsumer->details . ')')

@section('content')


    <div class="card">
        <div class="card-header p-4">
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">المستهلك</span>
                                    <span
                                        class="info-box-number text-center text-muted mb-0">{{ $subConsumer->details }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">المستهلك الرئيسي</span>
                                    <span
                                        class="info-box-number text-center text-muted mb-0">{{ $subConsumer->consumer->name }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">المسافة المقطوعة بين آخر قراءتي
                                        عدّاد</span>
                                    <span
                                        class="info-box-number text-center text-muted mb-0">{{ $subConsumer->getDistance() }}
                                        كيلو متر<span>
                                        </span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    </ul>
                </div>

                <div class="col-12 col-md-12 col-lg-12 order-1 order-md-2">
                    <div class="d-none">
                        {{ $operations = $subConsumer->operations }}
                        {{ $movementRecords = App\Models\MovementRecord::all()->where('sub_consumer_id', $subConsumer->id) }}
                        {{ $page = 'show' }}
                    </div>
                    @if ($operations || $movementRecords || $subConsumer->description)
                        <h3 class="text-primary"><i class="fas fa-paint-brush mr-2"></i>التفاصيل</h3>
                        @if ($subConsumer->description)
                            <p class="mt-4 mr-4">
                                {{ $subConsumer->description }}
                            </p>
                        @endif
                    @endif
                    <br>
                    @if ($operations)
                        <div class="d-none"> {{ $counter = 1 }}</div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title float-left mt-2">جدول العمليات</h3>
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
                                                {{ $va = App\Models\SubConsumer::withTrashed()->where('id', $operation->sub_consumer_id)->first() }}
                                            </div>
                                            <tr>
                                                <td>
                                                    {{ $counter++ }}
                                                </td>
                                                @if ($va !== null)
                                                    <td>
                                                        {{ $va->details }}
                                                    </td>
                                                    <td>{{ App\Models\Consumer::withTrashed()->where('id', $va->consumer_id)->first()->name }}
                                                    </td>
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
                                                <td style=" text-align: center">{{ number_format(+$operation->amount) }}
                                                </td>
                                                <td style=" text-align: center">{{ $operation->new_date }}</td>

                                                <td class="text-center align-middle">
                                                    <div class="btn-group">
                                                        <a href="{{ route('operations.show-outcome', $operation->id) }}"
                                                            class="btn btn-info"
                                                            style="border-top-right-radius: 10px;border-bottom-right-radius: 10px"><i
                                                                class="fas fa-eye"></i></a>
                                                        <a href="{{ route('operations.edit-outcome', [$operation->id, $page]) }}"
                                                            class="btn btn-success"><i class="fas fa-edit"></i></a>
                                                        <a href="#"
                                                            onclick="confirmDestroy('{{ $operation->id }}' , this)"
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
                    @endif

                    @if ($movementRecords)
                        <div class="d-none"> {{ $counter = 1 }}</div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title float-left mt-2">جدول قراءات العدّاد</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th style=" text-align: center">قراءة العدّاد</th>
                                            <th style=" text-align: center">التاريخ</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($movementRecords as $movementRecord)
                                            <tr>
                                                <td>
                                                    {{ $counter++ }}
                                                </td>
                                                <td style=" text-align: center">
                                                    {{ number_format(+$movementRecord->record) }}</td>
                                                <td style=" text-align: center">{{ $movementRecord->date }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer d-none">
                            </div>
                        </div>
                    @endif

                </div>

            </div>
        </div>
        <!-- /.card-body -->
    </div>


@endsection
