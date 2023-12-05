@extends('layouts.app')

@section('title', 'O кинотеатре')

@section('content')
<h2 class="mb-4 text-xl">Кинотеатр РАДУГА 3D</h2>
<p class="mb-4 text-slate-800">Кинотеатр располагается на 3 этаже ТРЦ "Радуга" и имеет два кинозала, готовые вместить по 76 зрителей в каждом, рядом есть кафе. Несмотря на небольшие размеры залов качество 3D видео и объемного звука на высоком уровне.</p>
<div id="map" style="width: 100%; height: 400px;"></div>

<script src="https://api-maps.yandex.ru/2.1/?apikey=3b289249-aa45-436b-9f75-fe916d6832a0&lang=ru_RU" type="text/javascript"></script>
<script type="text/javascript">
    ymaps.ready(init);

    function init() {
        var myMap = new ymaps.Map("map", {
            center: [59.92953938000481, 30.296060718032972],
            zoom: 15,
            controls: ['zoomControl']
        });

        var myPlacemark = new ymaps.Placemark([59.92953938000481, 30.296060718032972], {
            hintContent: "Наш кинотеатр", 
            balloonContent: "Кинотеатр РАДУГА 3D в ГУАП Питер"
        });

        myMap.geoObjects.add(myPlacemark);
        
        myMap.setBounds(myMap.geoObjects.getBounds(), {checkZoomRange: true});
    }
</script>

@endsection