<!DOCTYPE html>
<html dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>طباعة التقرير</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 4 -->

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Bootstrap 4 RTL -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/bootstrap.min.css') }}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}" />
    <!-- Custom style for RTL -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/sweet-alert2.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style>
        @page {
            margin-top: 70px;
            margin-bottom: 100px;
        }
    </style>
</head>

<body onload="window.print();">
    <div class="d-none"> {{ $counter = 1 }}</div>
    <div class="wrapper">
        <section class="invoice">
            <div class="d-none">
                {{ $numOfOperations = $operations->count() }}
                {{ $solarOutcome = $operations->where('foulType', 'سولار')->where('type', 'صرف')->sum('amount') }}
                {{ $solarIncome = $operations->where('foulType', 'سولار')->where('type', 'وارد')->sum('amount') }}
                {{ $banOutcome = $operations->where('foulType', 'بنزين')->where('type', 'صرف')->sum('amount') }}
                {{ $banIncome = $operations->where('foulType', 'بنزين')->where('type', 'وارد')->sum('amount') }}
            </div>
            <header>
                <div class="row">
                    <div class="col-12">
                        <h2 class="page-header">
                            {{-- <i class="fas fa-globe float-right ml-2"></i> --}}
                            <small class="float-right mt-2"><img src="{{ asset('assets/images/English.png') }}"
                                    alt=""></small>
                            <small class="float-center"><img style="width: 260px"
                                    src="{{ asset('assets/images/logo.png') }}" alt=""></small>
                            <small class="float-left "><img src="{{ asset('assets/images/Arabic.png') }}"
                                    alt=""></small>
                        </h2>
                    </div>
                    <!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-12">
                        <h4>
                            <i class="fas fa-globe"></i> مستشفى كمال عدوان
                            <small class="float-right">{{ Date::now(27) }}</small>
                        </h4>
                    </div>
                    <!-- /.col -->
                </div>
            </header>
            <div class="par mt-3">
                <p>
                    <b style="font-size: 24px">
                        الأخ/ مدير إدارة الإمداد والشؤون الهندسية -المحترم-
                    </b>
                    <br>
                    <br>
                    <b class="mt-2" style="font-size: 24px"> السلام عليكم ورحمة الله وبركاته.</b>
                    <br>
                    <br>
                    <b class="mt-2" style="font-size: 24px">
                        @if ($dischangeNumber)
                            مرفق لديكم التقرير التالي لعملية الصرف برقم سند الصرف ({{ $dischangeNumber }}):
                        @else
                            مرفق لديكم التقرير
                            @if ($reportDate == 'يومي')
                                اليومي
                            @else
                                التالي
                            @endif
                            @if ($type == 'صرف')
                                لعمليات الصرف
                            @elseif($type == 'وارد')
                                للعمليات الواردة
                            @else
                                لجميع العمليات
                            @endif
                            @if ($checked)
                                التي تحت المراجعة
                            @endif
                            @if ($consumer_id)
                                @if ($sub_consumer_id)
                                    للمستهلك
                                    ({{ App\Models\SubConsumer::withTrashed()->findOrFail($sub_consumer_id)->details }})
                                @else
                                    للمستهلكين
                                    ({{ App\Models\Consumer::withTrashed()->findOrFail($consumer_id)->name }})
                                @endif
                            @endif
                            @if ($foulType)
                                من نوع وقود ({{ $foulType }})
                            @endif
                            @if ($receiverName)
                                الذي استلمها ({{ $receiverName }})
                            @endif
                            @if ($reportDate == 'يومي')
                                لتاريخ {{ $from }}
                            @elseif($reportDate == 'لفترة')
                                للفترة من {{ $from }} إلى {{ $to }}
                            @else
                                @if ($from && $to == null)
                                    لتاريخ {{ $from }}
                                @elseif($from && $to)
                                    للفترة من {{ $from }} إلى {{ $to }}
                                @endif
                            @endif
                            :
                        @endif
                    </b>
                </p>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title float-left mt-2">جدول العمليات</h3>
                </div>
                <!-- /.card-header -->
                <div class="d-none">
                    {{ $spaces = 0 }}
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>المستهلك</th>
                                <th>المستهلك الأساسي</th>
                                <th> اسم المستلم</th>
                                <th style="width: 60px ; text-align: center">النوع</th>
                                <th style="width: 105px ; text-align: center">سند الصرف</th>
                                <th style="width: 100px ; text-align: center">نوع الوقود</th>
                                <th style="width: 70px ; text-align: center">الكمية</th>
                                <th style="width: 120px ; text-align: center">التاريخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < $numOfOperations; $i++)
                                <div class="d-none">
                                    {{ $operation = $operations->get($counter - 1) }}
                                </div>
                                @if ($operation)
                                    <div class="d-none">
                                        {{ $va = App\Models\SubConsumer::where('id', $operation->sub_consumer_id)->withTrashed()->first() }}
                                        {{ $spaces++ }}
                                    </div>
                                    <tr>
                                        <td>
                                            {{ $counter++ }}
                                        </td>
                                        @if ($va !== null)
                                            <td>
                                                {{ $va->details }}
                                            </td>
                                            <td>{{ App\Models\Consumer::where('id', $va->consumer_id)->withTrashed()->first()->name }}
                                            </td>
                                            <td>{{ $operation->receiverName }}</td>
                                            <td style=" text-align: center;">
                                                {{ $operation->type }}</td>
                                            <td style=" text-align: center">{{ $operation->dischangeNumber }}
                                            </td>
                                        @else
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td style=" text-align: center">{{ $operation->type }}</td>
                                            <td style=" text-align: center">-</td>
                                        @endif
                                        <td style=" text-align: center">{{ $operation->foulType }}</td>
                                        <td style=" text-align: center">
                                            {{ number_format($operation->amount, 2) }}
                                        </td>
                                        <td style=" text-align: center">{{ $operation->date }}</td>
                                    </tr>
                                @endif
                            @endfor
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <div class="total">
                <table border="1" style="width: 35%; text-align: center;">
                    <tr>
                        <th style="font-size: 18px ; padding: 5px">التفاصيل</th>
                        <th style="font-size: 18px ; padding: 5px">القيمة</th>
                    </tr>
                    <tr>
                        <td style="font-size: 18px ; padding: 5px">عدد العمليات</td>
                        <td style="font-size: 18px ; padding: 5px">{{ $numOfOperations }} عملية</td>
                    </tr>
                    @if ($solarIncome)
                        <tr>
                            <td style="font-size: 18px ; padding: 5px">كمية السولار الواردة</td>
                            <td style="font-size: 18px ; padding: 5px">{{ $solarIncome }} لتر</td>
                        </tr>
                    @endif
                    @if ($solarOutcome)
                        <tr>
                            <td style="font-size: 18px ; padding: 5px">كمية السولار المصروفة</td>
                            <td style="font-size: 18px ; padding: 5px">{{ $solarOutcome }} لتر</td>
                        </tr>
                    @endif
                    @if ($banIncome)
                        <tr>
                            <td style="font-size: 18px ; padding: 5px">كمية البنزين الواردة</td>
                            <td style="font-size: 18px ; padding: 5px">{{ $banIncome }} لتر</td>
                        </tr>
                    @endif
                    @if ($banOutcome)
                        <tr>
                            <td style="font-size: 18px ; padding: 5px">كمية البنزين المصروفة</td>
                            <td style="font-size: 18px ; padding: 5px">{{ $banOutcome }} لتر</td>
                        </tr>
                    @endif
                </table>
            </div>
        </section>
        <footer>
            <div style="text-align: center; float: left; " class="mt-4">
                <p>التوقيع</p>
                <p>رئيس قسم المحروقات</p>
            </div>
        </footer>
    </div>
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.13.4 -->
    <script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 rtl -->
    <script src="{{ asset('assets/dist/js/bootstrap.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- SweetAlert2 -->
    {{-- <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script> --}}
    <!-- Toastr -->
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('assets/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jqvmap/maps/jquery.vmap.world.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('assets/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('assets/dist/js/pages/dashboard.js') }}"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('assets/dist/js/demo.js') }}"></script>
    <script src="{{ asset('assets/dist/js/sweet-alert2.js') }}"></script>
    <script src="{{ asset('assets/dist/js/axios.js') }}"></script>

</body>


</html>
