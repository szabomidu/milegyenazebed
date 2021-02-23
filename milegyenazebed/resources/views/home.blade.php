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
    let data = [[1,1,1,1,1],[2,2,2,2,2], [3,3,3,3,3], [4,4,4,4,4], [5,5,5,5,5], [6,6,6,6,6], [7,7,7,7,7], [8,8,8,8,8], [9,9,9,9,9], [10,10,10,10,10], [11,11,11,11,11], [12,12,12,12,12]]
    document.addEventListener('DOMContentLoaded', function () {
        Highcharts.chart('container', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Top 15 food from 2019 to 2021'
            },
            xAxis: {
                categories: ['Africa', 'America', 'Asia', 'Europe', 'Oceania'],
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
                data: [98, 76, 54, 32, 11]
            }]
        });

        let select = document.getElementById('select');
        select.addEventListener('change', (e) => {
            let month = e.target.value;
            Highcharts.charts.forEach((chart) => {
                chart.series[0].update({
                    data: data[month]
                }, false, false, false);
                chart.xAxis[0].categories=data[month]
                chart.redraw();
            });
        })
    });
</script>

<select name="" id="select">
    <option value="0">January</option>
    <option value="1">February</option>
    <option value="2">March</option>
    <option value="3">April</option>
    <option value="4">May</option>
    <option value="5">June</option>
    <option value="6">July</option>
    <option value="7">August</option>
    <option value="8">September</option>
    <option value="9">October</option>
    <option value="10">November</option>
    <option value="11">December</option>
</select>
<div id="container" style="width:100%; height:400px;"></div>

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
            {{ htmlspecialchars($dish->dish_name)}}
        </div>
    @endforeach

@else
    <a href="{{url('register')}}">Registration</a><br>
    <a href="{{url('login')}}">Login</a><br><br>
    <div> Log in to see the menu!</div>

@endif

</body>
</html>
