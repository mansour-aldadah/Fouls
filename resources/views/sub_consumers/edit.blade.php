@extends('parent')

@section('title', 'إنشاء مستهلك فرعي')

@section('header', 'إنشاء مستهلك فرعي')

@section('content')

    <div class="container">
        <div class="card card-primary">
            <div class="card-header ">
                <h3 class="card-title p-2"></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="form">
                @csrf
                <div class="card-body">
                    <div class="form-group" data-select2-id="13">
                        <label>المستهلك الرئيسي</label>
                        <select class="form-control select2 select2-hidden-accessible" id="consumer_id" name="consumer_id"
                            style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                            @foreach ($consumers as $consumer)
                                <option value="{{ $consumer->id }}" @if ($consumer->id == $subConsumer->consumer_id) selected @endif>
                                    {{ $consumer->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="details">تفاصيل المستهلك</label>
                        <input type="text" class="form-control" id="details" name="details"
                            value="@if (old('details')) {{ old('details') }} @else {{ $subConsumer->details }} @endif"
                            placeholder="أدخل تفاصيل المستهلك">
                    </div>
                    <div class="form-group">
                        <label for="description">تفاصيل المستهلك</label>
                        <input type="text" class="form-control"
                            value="@if (old('description')) {{ old('description') }} @else {{ $subConsumer->description }} @endif"
                            id="description" name="description" placeholder="أدخل تفاصيل المستهلك">
                    </div>
                    <div class="form-group mt-4">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="hasRecord"
                                @if (old('hasRecord')) checked @elseif($subConsumer->hasRecord) checked @endif>
                            <label for="hasRecord" class="custom-control-label">له عداد</label>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="button" onclick="update({{ $subConsumer->id }})" class="btn btn-primary">تعديل</button>
                </div>
            </form>
        </div>
    </div>

@endsection


@section('script')

    <script>
        function update(id) {
            var con_id = document.getElementById('consumer_id').value;
            axios.put('/sub_consumers/' + id, {
                    consumer_id: document.getElementById('consumer_id').value,
                    details: document.getElementById('details').value,
                    description: document.getElementById('description').value,
                    hasRecord: document.getElementById('hasRecord').checked
                })
                .then(function(response) {
                    window.location.href = '/consumers/' + con_id;
                    showMessage(response.data);
                })
                .catch(function(error) {
                    showMessage(error.response.data);
                });
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
