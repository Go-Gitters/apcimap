import React from "react";
import {Component} from 'react';
import ReactMapGL from 'react-map-gl';



export const Home = () => {
	const state = {
		viewport: {
			width: 400,
			height: 400,
			latitude: 37.7577,
			longitude: -122.4376,
			zoom: 8
		}
	}
	return (
		<>
			<h1>Home</h1>

			<ReactMapGL
				{...state.viewport}
				mapboxApiAccessToken='pk.eyJ1Ijoia3lsYWJlbmR0IiwiYSI6ImNrM25oZW5hMjFnYm4zbG40d3ljNWRwMTUifQ.vZe28vwUNPkzafr1vuHDtQ'

			/>
		</>
	)
}