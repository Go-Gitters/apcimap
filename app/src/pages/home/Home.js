import React, {useState} from "react";
import {Component} from 'react';
import ReactMapGL from 'react-map-gl';


export const Home = () => {
	const [mapboxViewport, setMapboxViewport] = useState({
		width: 800,
		height: 600,
		latitude: 35,
		longitude: -107,
		zoom: 8
	});
	return (
		<>

			<ReactMapGL
				mapboxApiAccessToken='pk.eyJ1Ijoia3lsYWJlbmR0IiwiYSI6ImNrM25oZW5hMjFnYm4zbG40d3ljNWRwMTUifQ.vZe28vwUNPkzafr1vuHDtQ'
				 mapStyle={'mapbox://styles/kylabendt/ck3ni0wwo4fxi1cpv0qchtsml'}
				{...mapboxViewport}
				onViewportChange={(viewport) => {
					setMapboxViewport((viewport))
				}}

			/>
		</>
	);
}