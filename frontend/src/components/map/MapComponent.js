import React, {useEffect, useState} from 'react';
import './map.css'

const MapComponent = () => {
    let [weatherRequestHistory, setWeatherRequestHistory] = useState([]);

    const addItem = (message) => {
        if (message) {
            const updatedArray = [...weatherRequestHistory, JSON.stringify(message)];
            setWeatherRequestHistory(updatedArray);
            weatherRequestHistory = updatedArray;
            localStorage.setItem("weatherRequestHistory", JSON.stringify(updatedArray));
        }
    };

    let init = () => {
        const mapElement = document.getElementById('map-container');
        const dataMapInitializedAttributeName = 'data-map-initialized';

        if (!mapElement.getAttribute(dataMapInitializedAttributeName)) {

            const retrievedArray = JSON.parse(localStorage.getItem("weatherRequestHistory"));
            if (retrievedArray) {
                setWeatherRequestHistory(retrievedArray);
                weatherRequestHistory = retrievedArray;
            }

            const script = document.createElement('script');
            script.src = 'https://api-maps.yandex.ru/2.1/?apikey=e8e72aff-26c1-45c1-a343-164a657f03d6&lang=en_US' + '&rndsrt=' + Math.random();
            script.async = true;
            script.onload = () => initializeMap();
            document.body.appendChild(script);

            const initializeMap = () => {
                window.ymaps.ready(function(){
                    if (!mapElement.getAttribute(dataMapInitializedAttributeName)) {
                        const map = new window.ymaps.Map('map-container', {
                            center: [58.608081, 49.632730],
                            zoom: 11,
                        });
                        mapElement.setAttribute(dataMapInitializedAttributeName, "true");
                        map.events.add('click', async (event) => {
                            const clickedCoords = event.get('coords');
                            try {
                                const response = await fetch(`http://localhost:8001/api/weather/current-weather?latitude=${clickedCoords[0]}&longitude=${clickedCoords[1]}`);
                                const data = await response.json();
                                const message = 'There is ' + Math.round(data.data.main.temp - 273,15) + '°C in ' + data.data.name;

                                let date = new Date();
                                // addItem(message + ` at ${date.getFullYear()}.${date.getMonth()}.${date.getDate()} ${date.getHours()}:${date.getMinutes()}:${date.getSeconds()}`)
                                addItem(data)

                                document.querySelector('#hat-text').innerHTML = message;
                            } catch (error) {
                                console.error('Error:', error);
                            }
                        });
                    }

                })

            };
        }
    }

    useEffect(() => {setWeatherRequestHistory(weatherRequestHistory)}, [])

    setTimeout(()=> {
        if (init) {
            console.log(123);
            init();
        }
        init = false;
    }, 1000);

    const unixTimeToTime = (unixTime) => {
        let date = new Date(unixTime * 1000);
        let year = date.getFullYear();
        let month = date.getMonth();
        let day = date.getDay();
        let hours = date.getHours();
        let minutes = "0" + date.getMinutes();
        let seconds = "0" + date.getSeconds();
        return `${year}.${month}.${day} ${hours}:${minutes.substr(-2)}:${seconds.substr(-2)}`;
    }

    return  <div>
                <h2>Weather-Map</h2>
                <p>Click on map to get current weather of the place</p>
                <div id="map-container" className={'weather-map'}>
                    <div className="weather-map__hat">
                        <span id="hat-text" className="weather-map__hat-text">
                        </span>
                    </div>
                </div>
                <div>History: {weatherRequestHistory.length} elements</div>
                <ul>
                    <table className="weather-map__table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>City</th>
                            <th>Temperature</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Date & Time</th>
                        </tr>
                        </thead>
                        <tbody>
                        {weatherRequestHistory.slice(0).reverse().map((item, index) => JSON.parse(item)).map((item, index) => (
                            <tr key={index}>
                                <td>{weatherRequestHistory.length - index}</td>
                                <td>{item.data.name}</td>
                                <td>{Math.round(item.data.main.temp - 273,15)} °C</td>
                                <td>{item.data.coord.lat}</td>
                                <td>{item.data.coord.lon}</td>
                                <td>{unixTimeToTime(item.data.dt)}</td>
                            </tr>
                        ))}
                        </tbody>
                    </table>
                </ul>
            </div>
};

export default MapComponent;