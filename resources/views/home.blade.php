@extends('parent')

@section('title', 'نظام إدارة المحروقات')

@section('header', 'نظام إدارة المحروقات')

@section('content')

    @if (session()->has('messege'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <h5><i class="icon fas fa-check"></i> تأكيد !</h5>
            {{ session('messege') }}
        </div>
    @endif
    </div>
    <div class="container">
        <div class="row">
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3 class="d-inline-block ml-2">{{ number_format(App\Models\SubConsumer::numberOfSubConsumers()) }}
                            <h5 class="d-inline-block">
                                (مستهلك)</h5>
                        </h3>
                        <p>عدد المستهلكين</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="{{ route('sub_consumers.index') }}" class="small-box-footer"> <span
                            class="pb-1 d-inline-block">عرض المزيد</span><i
                            class="fas fa-arrow-circle-left mr-2 pt-1"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 class="d-inline-block ml-2">{{ number_format(App\Models\Operation::getIncomes()) }} <h5
                                class="d-inline-block">
                                (لتر)</h5>
                        </h3>
                        <p>إجمالي الوارد</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                    <a href="{{ route('operations.index-income', ['time' => 'all']) }}" class="small-box-footer"> <span
                            class="pb-1 d-inline-block">عرض المزيد</span><i
                            class="fas fa-arrow-circle-left mr-2 pt-1"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 class="d-inline-block ml-2">{{ number_format(App\Models\Operation::getIncomeMonth()) }} <h5
                                class="d-inline-block">
                                (لتر)</h5>
                        </h3>
                        <p>الوارد الشهري</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                    <a href="{{ route('operations.index-income', ['time' => 'month']) }}" class="small-box-footer"> <span
                            class="pb-1 d-inline-block">عرض المزيد</span><i
                            class="fas fa-arrow-circle-left mr-2 pt-1"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 class="d-inline-block ml-2">{{ number_format(App\Models\Operation::getTotal()) }} <h5
                                class="d-inline-block">
                                (لتر)</h5>
                        </h3>
                        <p>إجمالي المتوفر</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-th-large"></i>
                    </div>
                    <a href="{{ route('operations.index') }}" class="small-box-footer"> <span
                            class="pb-1 d-inline-block">عرض المزيد</span><i
                            class="fas fa-arrow-circle-left mr-2 pt-1"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 class="d-inline-block ml-2">{{ number_format(App\Models\Operation::getToday()) }} <h5
                                class="d-inline-block">
                                (لتر)</h5>
                        </h3>
                        <p>الصرف اليومي</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-arrow-up"></i>
                    </div>
                    <a href="{{ route('operations.index-outcome', ['time' => 'today']) }}" class="small-box-footer"> <span
                            class="pb-1 d-inline-block">عرض المزيد</span><i
                            class="fas fa-arrow-circle-left mr-2 pt-1"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 class="d-inline-block ml-2">{{ number_format(App\Models\Operation::getWeek()) }} <h5
                                class="d-inline-block">
                                (لتر)</h5>
                        </h3>
                        <p>الصرف الأسبوعي</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-arrow-up"></i>
                    </div>
                    <a href="{{ route('operations.index-outcome', ['time' => 'week']) }}" class="small-box-footer"> <span
                            class="pb-1 d-inline-block">عرض المزيد</span><i
                            class="fas fa-arrow-circle-left mr-2 pt-1"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 class="d-inline-block ml-2">{{ number_format(App\Models\Operation::getMonth()) }} <h5
                                class="d-inline-block">
                                (لتر)</h5>
                        </h3>
                        <p>الصرف الشهري</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-arrow-up"></i>
                    </div>
                    <a href="{{ route('operations.index-outcome', ['time' => 'month']) }}" class="small-box-footer"> <span
                            class="pb-1 d-inline-block">عرض المزيد</span><i
                            class="fas fa-arrow-circle-left mr-2 pt-1"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3 class="d-inline-block ml-2">{{ number_format(App\Models\Operation::getOutcomes()) }} <h5
                                class="d-inline-block">
                                (لتر)</h5>
                        </h3>
                        <p>إجمالي المصروف</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-arrow-up"></i>
                    </div>
                    <a href="{{ route('operations.index-outcome', ['time' => 'all']) }}" class="small-box-footer"> <span
                            class="pb-1 d-inline-block">عرض المزيد</span><i
                            class="fas fa-arrow-circle-left mr-2 pt-1"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="d-none">
        {{ $page = 'home' }}
    </div>
    <div class="d-none"> {{ $counter = 1 }}</div>
    <div class="container">
        <div class="card">
            <div class="card-header">
                @if ($operations->count() < 10)
                    <h3 class="card-title float-left mt-2">آخر العمليات</h3>
                @else
                    <h3 class="card-title float-left mt-2">آخر 10 عمليات</h3>
                @endif
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
                                <td style=" text-align: center">{{ number_format($operation->amount) }}</td>
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
            <div class="card-footer d-none">
            </div>
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
