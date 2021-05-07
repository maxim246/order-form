@extends('layouts.app')

@section('header')
<link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css"/>
@endsection

@section('content')
<h1>Форма заказа</h1>
<div class="form-group center-block" style="width:50%;">
    <form action="{{route('order-store')}}" class="order-form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

        <label for="phone">Телефон</label>
        <input type="text" class="form-control" id="phone" name="phone" value="+7" maxlength="12">
        <br>

        <label for="name">Ваше имя</label>
        <input type="text" class="form-control" id="name" name="name">
        <br>

        <label for="rate">Тариф</label>
        <select class="form-select form-control" aria-label="Выберите тариф" name="rate_id" id="rate">
            @foreach ($rates as $rate)
                <option value="{{$rate->id}}">{{$rate->name}}</option>
            @endforeach
        </select>
        <br>

        <div class="form-group">
            <label for="datepicker">Дата</label>
            <div class="input-group date" id="datepicker">
                <input type="text" class="form-control" name="date"/>
                <span class="input-group-addon">
                    <span class="glyphicon-calendar glyphicon"></span>
                </span>
            </div>
        </div>

        <div class="address">
            <label for="address-input">Адрес</label>
            <input class="form-control" id="address-input" name="address"/>
            <br>

            <div class="address-variants">
                <b>Варианты</b>
                <br>
                <ul id="address-list" class="list-group">
                </ul>
                <br>
            </div>
        </div>

        <input type="button" class="form-control btn btn-primary" value="Создать заказ" id="create-order">
    </form>

    {{--@if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif--}}
</div>

<style>
    body {
        font-size: 16px;
    }
    .order-form{
        text-align:left;
    }
    .order-form #phone {
        width: 25%;
    }
    .order-form #rate, .order-form #datepicker{
        width: 50%;
    }

    .address-variants {
        display:none;
    }
    .address-link{
        cursor:pointer;
    }
</style>

<script>
    $('.order-form>#rate').on('click', function() {
        let rateId = $(this).val();

        $.ajax({
            method: 'post',
            url: '/forbidden-rate-days/'+rateId,
            data: {_token: "{{ csrf_token() }}" },
            success: function (data) {
                let parseData = JSON.parse(data);
                let forbiddenDays = [];
                for (let prop in parseData.forbiddenDays) {
                    forbiddenDays.push(prop);
                }

                $('#datepicker').data("DateTimePicker").daysOfWeekDisabled(forbiddenDays);
            }
        });
    });

    $('.order-form>#create-order').on('click', function() {
        $.ajax({
            method: 'post',
            url: '/store',
            data: $('.order-form').serialize(),
            success: function (data) {

            },
            error: function (data) {
                let parseData = JSON.parse(data);
                console.log(parseData.errors);
            }
                /*let data = response.responseJSON.errors;
                $.each( data, function( key, value ) {
                    $( "<span class='text-danger'>"+value+"</span>" ).insertAfter( "#"+key );
                });*/

        });
    });

    timerId = null;
    $('.order-form>.address>#address-input').on('keyup', function() {
        clearTimeout(timerId);
        timerId = setTimeout(function() {
            $.ajax({
                method: 'post',
                url: '/address-hints',
                data: {_token: "{{ csrf_token() }}", query: $('.order-form>.address>#address-input').val() },
                success: function (data) {
                    let parseData = JSON.parse(data);
                    console.log(parseData);
                    $('.order-form>.address>.address-variants>#address-list').empty();

                    $.each(parseData, function (i, item) {
                        console.log(parseData[i]);
                        $('.order-form>.address>.address-variants>#address-list').append("<li class='list-group-item'><a class='address-link'>" + item + "</a></li>");
                        $('.order-form>.address>.address-variants').css('display', 'block');
                    });
                }
            });
        }, 1000);
    });

    $(document).on('click','.address-link', function(e) {
        $('.order-form>.address>#address-input').val(e.target.innerHTML);
    });

</script>
<script src="js/moment-with-locales.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('#datepicker').datetimepicker({
            locale: 'ru',
            format: 'DD.MM.YYYY',
            daysOfWeekDisabled:[0,1],
        });
    });
</script>

@endsection
