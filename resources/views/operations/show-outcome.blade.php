@extends('parent')

@section('title', 'العملية')

@section('header', 'العملية')

@section('content')

    @if (session()->has('messege'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <h5><i class="icon fas fa-check"></i> تأكيد !</h5>
            {{ session('messege') }}
        </div>
    @endif

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
                                    <span class="info-box-text text-center text-muted">التاريخ</span>
                                    <span
                                        class="info-box-number text-center text-muted mb-0">{{ $operation->new_date }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">الكمية</span>
                                    <span
                                        class="info-box-number text-center text-muted mb-0">{{ number_format($operation->amount) }}
                                        (لتر)</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">نوع الوقود</span>
                                    <span
                                        class="info-box-number text-center text-muted mb-0">{{ $operation->foulType }}<span>
                                        </span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    </ul>
                </div>

                <div class="col-12 col-md-12 col-lg-12 order-1 order-md-2">
                    <h3 class="text-primary"><i class="fas fa-paint-brush mr-2"></i>التفاصيل</h3>
                    <br>
                    <div class="text-muted">
                        <p class="">رقم سند الصرف
                            <b class="d-block">#{{ $operation->dischangeNumber }}</b>
                        </p>
                        <p class="">اسم المستلم
                            <b class="d-block">{{ $operation->receiverName }}</b>
                        </p>
                        <p class="">المستهلك الأساسي
                            <b
                                class="d-block">{{ $basic = $operation->subConsumer()->first()->consumer()->first()->name }}</b>
                        </p>
                        <p class="">المستهلك الفرعي
                            <b class="d-block">{{ $part = $operation->subConsumer()->first()->details }}</b>
                        </p>
                    </div>
                    @if ($operation->description)
                        <div class="row">
                            <div class="col-12">
                                <h4>الوصف</h4>
                                <div class="post">
                                    <!-- /.user-block -->
                                    <p>
                                        {{ $operation->description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                    <h4>المختصر:</h4>
                    <div class="text-muted">
                        <p class="text-sm">تم صرف
                            <b class="d-inline">{{ number_format($operation->amount) }}</b> (لتر)
                            <b class="d-inline">{{ $operation->foulType }}</b>
                            للمستهلك
                            <b class="d-inline">{{ $part }}</b>
                            وهو من ضمن
                            <b class="d-inline">{{ $basic }}</b>
                            وتم تسليم الكمية ل
                            <b class="d-inline">{{ $operation->receiverName }}</b>
                            برقم سند الصرف
                            <b class="d-inline">#{{ $operation->dischangeNumber }}</b>
                            وذلك بتاريخ
                            <b class="d-inline">{{ $operation->new_date }}</b>
                        </p>
                    </div>
                    <div class="text-center mt-5 mb-3">
                        @if ($operation->type == 'وارد')
                            <a href="{{ route('operations.edit-income', $operation->id) }}" class="btn btn-sm btn-info"
                                style="width: 100px"><i class="fas fa-edit"></i> تعديل
                            </a>
                        @else
                            <a href="{{ route('operations.edit-outcome', $operation->id) }}" class="btn btn-sm btn-info"
                                style="width: 100px"><i class="fas fa-edit"></i> تعديل
                            </a>
                        @endif
                        <a href="#" class="btn btn-sm btn-danger"
                            onclick="confirmDestroy('{{ $operation->id }}' , this)" style="width: 100px"><i
                                class="fas fa-trash"></i>
                            حذف</a>
                    </div>
                </div>

            </div>
        </div>
        <!-- /.card-body -->
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
                    window.location.href = '/operations'
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
