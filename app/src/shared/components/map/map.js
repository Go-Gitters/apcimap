import React, {useState} from "react";
import MapGL, {Marker, Source, Layer, Popup} from 'react-map-gl';
import {crimeLayer, dataLayer} from "./map-style";
import CRIMES from './crimes';
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faMapMarker} from "@fortawesome/free-solid-svg-icons";

export const Map = () => {
	const [mapboxViewport, setMapboxViewport] = useState({
		width: 800,
		height: 700,
		latitude: 35.1129685,
		longitude: -106.5670637,
		zoom: 12
	});

	const[popupInfo, setPopupInfo] = useState(null);


	function renderCrimeMarker(crime) {
		return (
			<Marker longitude={crime.longitude} latitude={crime.latitude}>
				<FontAwesomeIcon icon={faMapMarker} size="2x" className="text-danger" onClick={() => setPopupInfo(crime)}/>
			</Marker>
		);
	}

	function renderPopup() {

		if(popupInfo){
		return (

			<Popup
				tipSize={5}
				anchor="top"
				longitude={popupInfo.longitude}
				latitude={popupInfo.latitude}
				closeOnClick={false}
				onClose={() => setPopupInfo(null)}
			>
				<div><strong>Crime Type: </strong>{popupInfo.type}</div>
				{/*<div><strong>Crime Date: </strong>{popupInfo.type}</div>*/}
			</Popup>

		)
		}
	}

	return (
		<>
			<MapGL
				className="border border-dark d-inline-block"
				mapboxApiAccessToken='pk.eyJ1Ijoia3lsYWJlbmR0IiwiYSI6ImNrM25oZW5hMjFnYm4zbG40d3ljNWRwMTUifQ.vZe28vwUNPkzafr1vuHDtQ'
				mapStyle={'mapbox://styles/kylabendt/ck3ni0wwo4fxi1cpv0qchtsml'}
				{...mapboxViewport}
				onViewportChange={(viewport) => {
					setMapboxViewport((viewport))
				}}
			>
				{CRIMES.map((crime) => renderCrimeMarker(crime))}
				{renderPopup()}

			</MapGL>
		</>
	);
}