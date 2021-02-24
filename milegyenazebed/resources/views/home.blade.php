<!doctype html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <title>Mi legyen az ebéd?</title>
</head>
<body>
<script>
    let data = {!! json_encode($data) !!};
    document.addEventListener('DOMContentLoaded', function () {
        Highcharts.chart('container', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Top 15 food from 2019 to 2021'
            },
            xAxis: {
                categories: {!! json_encode($topfood["food"]) !!},
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Occurrence of the food (days)',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' days'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -40,
                y: 80,
                floating: true,
                borderWidth: 1,
                backgroundColor:
                    Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
                shadow: true
            },
            credits: {
                enabled: false
            },
            series: [{
                name: '2019-2021',
                data: {!! json_encode($topfood["numbers"]) !!},
            }]
        });

        let select = document.getElementById('select');
        select.addEventListener('change', (e) => {
            let month = e.target.value;
            Highcharts.charts.forEach((chart) => {
                chart.series[0].update({
                    data: data[month]
                }, false, false, false);
                chart.xAxis[0].categories=data[month];
                chart.redraw();
            });
        })
    });
</script>

<select name="" id="select">
    <option value="1">January</option>
    <option value="2">February</option>
    <option value="3">March</option>
    <option value="4">April</option>
    <option value="5">May</option>
    <option value="6">June</option>
    <option value="7">July</option>
    <option value="8">August</option>
    <option value="9">September</option>
    <option value="10">October</option>
    <option value="11">November</option>
    <option value="12">December</option>
</select>
<div id="container" style="width:100%; height:400px;"></div>

<form method="POST" action="/">
    @csrf
    <select name="subscription" id="subscription">
        @foreach($selectOptions as $option)
            <option value="{{$option->dish_name}}"> {{strtoupper($option->dish_name)}} </option>
        @endforeach
    </select>
    <input type="submit" value="Subscribe">
</form>


@if( auth()->check() )
    <form action="{{url('logout')}}" method="post">
        @csrf
        <input type="submit" value="Logout">
    </form>
    {{$date}}

    @foreach($dishes as $dish)
        <div>@if($dish->dish_name === "Lencsefőzelék" || $dish->dish_name === "LENCSEFŐZELÉK")
                LEGJOBB!!
            @elseif($dish->is_new)
                ÚJ
            @endif
            {!! ucfirst(strtolower($dish->dish_name)) !!}
        </div>
    @endforeach

@else
    <a href="{{url('register')}}">Registration</a><br>
    <a href="{{url('login')}}">Login</a><br><br>
    <div> Log in to see the menu!</div>

@endif

</body>
</html>
