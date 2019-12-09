import React, {useState, useEffect} from "react";
import MapGL, {Marker, Source, Layer, Popup} from 'react-map-gl';
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faMapMarker} from "@fortawesome/free-solid-svg-icons";
import {useDispatch, useSelector} from "react-redux";
import {getCrimeByCrimeLocation} from "../../actions/get-crime";


export const Map = () => {


	const crimes = useSelector(state => (state.crimes ? state.crimes : []));
	const dispatch = useDispatch();
	const effects = () => {
		dispatch(getCrimeByCrimeLocation(35.1129685, -106.5670637, .1));
	};

	const inputs = [];

	useEffect(effects, inputs);

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
			<Marker longitude={crime.crimeLongitude} latitude={crime.crimeLatitude}>
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
				longitude={popupInfo.crimeLongitude}
				latitude={popupInfo.crimeLatitude}
				closeOnClick={false}
				onClose={() => setPopupInfo(null)}
			>
				<div><strong>Report Type: </strong>{popupInfo.crimeType}</div>
				<div><strong>Report Address: </strong>{popupInfo.crimeAddress}</div>
				{/*<div><strong>Crime Date: </strong>{popupInfo.type}</div>*/}
			</Popup>

		)
		}
	}
	console.info(crimes);

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
				{crimes.map((crime) => renderCrimeMarker(crime))}
				{renderPopup()}

			</MapGL>
		</>
	);
}