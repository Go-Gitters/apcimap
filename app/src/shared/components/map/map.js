import React, {useState, useEffect} from "react";
import MapGL, {Marker, Source, Layer, Popup} from 'react-map-gl';
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faDotCircle, faMapMarker} from "@fortawesome/free-solid-svg-icons";
import {useDispatch, useSelector} from "react-redux";
import {getCrimeByCrimeLocation} from "../../actions/get-crime";
import {getPropertyByPropertyLocation} from "../../actions/get-property";


export const Map = () => {

	const [mapboxViewport, setMapboxViewport] = useState({
		width: "100%",
		height: "80vh",
		latitude: 35.1129685,
		longitude: -106.5670637,
		zoom: 15
	});

	const crimes = useSelector(state => (state.crimes ? state.crimes : []));
	const properties = useSelector(state => (state.properties ? state.properties : []));
	const dispatch = useDispatch();
	const effects = () => {
		dispatch(getCrimeByCrimeLocation(mapboxViewport.latitude, mapboxViewport.longitude, 1));
		dispatch(getPropertyByPropertyLocation(mapboxViewport.latitude, mapboxViewport.longitude, .1));
	};

	const inputs = [mapboxViewport];

	useEffect(effects, inputs);


	const[popupInfo, setPopupInfo] = useState(null);
	const[propPopupInfo, setPropPopupInfo] = useState(null);


	function renderCrimeMarker(crime) {
		if(mapboxViewport.zoom > 12) {
			return (
				<Marker longitude={crime.crimeLongitude} latitude={crime.crimeLatitude}>
					<FontAwesomeIcon icon={faMapMarker} size="2x" className="text-danger"
										  onClick={() => setPopupInfo(crime)}/>
				</Marker>
			);
		}
	}

	function renderPropertyMarker(property) {
		if(mapboxViewport.zoom > 14) {
			return (
				<Marker longitude={property.propertyLongitude} latitude={property.propertyLatitude}>
					<FontAwesomeIcon icon={faDotCircle} onClick={() => setPropPopupInfo(property)}/>
				</Marker>
			);
		}
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

	function renderPropPopup() {
		if(propPopupInfo){
			return (

				<Popup
					tipSize={5}
					anchor="top"
					longitude={propPopupInfo.propertyLongitude}
					latitude={propPopupInfo.propertyLatitude}
					closeOnClick={false}
					onClose={() => setPropPopupInfo(null)}
				>
					<div><strong>Property Address: </strong>{propPopupInfo.propertyStreetAddress}</div>
					<div><strong>Assessed Property Value: </strong>{propPopupInfo.propertyValue}</div>
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
				{crimes.map((crime) => renderCrimeMarker(crime))}
				{properties.map((property) => renderPropertyMarker(property))}
				{renderPropPopup()}
				{renderPopup()}

			</MapGL>
		</>
	);
}