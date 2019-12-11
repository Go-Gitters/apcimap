import React, {useState, useEffect} from "react";
import MapGL, {Marker, Source, Layer, Popup} from 'react-map-gl';
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faHome, faMapMarker} from "@fortawesome/free-solid-svg-icons";
import {useDispatch, useSelector} from "react-redux";
import {getCrimeByCrimeLocation} from "../../actions/get-crime";
import {getPropertyByPropertyLocation} from "../../actions/get-property";
import Button from "react-bootstrap/Button";
import {faGithub} from "@fortawesome/free-brands-svg-icons";
import Col from "react-bootstrap/Col";
import {Star} from "../star/Star";


export const Map = () => {
	//Set initial view port
	const [mapboxViewport, setMapboxViewport] = useState({
		width: "100%",
		height: "80vh",
		latitude: 35.1129685,
		longitude: -106.5670637,
		zoom: 18.01
	});
	const stars = useSelector(state => (state.stars ? state.stars : []));
	const crimes = useSelector(state => (state.crimes ? state.crimes : []));
	const properties = useSelector(state => (state.properties ? state.properties : []));
	const dispatch = useDispatch();
	let distance = 1;
	//effects will run when viewport changes - pulls new data
	const effects = () => {
		//change distance to send to query depending on zoom level
		if(mapboxViewport.zoom > 18) {
			distance = .08
		} else if(mapboxViewport.zoom > 17) {
			distance = .15
		} else if(mapboxViewport.zoom > 16) {
			distance = .25
		} else if(mapboxViewport.zoom > 15) {
			distance = .5
		} else if(mapboxViewport.zoom > 14) {
			distance = 1
		} else if(mapboxViewport.zoom > 13.5) {
			distance = 1.5
		}else {
			distance = 2
		}
	//get new data is zoomed in enough to actually be showing
		if (mapboxViewport.zoom >= 13) {
			dispatch(getCrimeByCrimeLocation(mapboxViewport.latitude, mapboxViewport.longitude, distance));
		}
		if (mapboxViewport.zoom >= 16) {
			dispatch(getPropertyByPropertyLocation(mapboxViewport.latitude, mapboxViewport.longitude, distance));
		}
	};
	//this is for useEffect
	const inputs = [mapboxViewport];
	//actually call useEffect
	useEffect(effects, inputs);


	const[popupInfo, setPopupInfo] = useState(null);
	const[propPopupInfo, setPropPopupInfo] = useState(null);

	function renderCrimeMarker(crime) {
		if(mapboxViewport.zoom >= 13) {
			return (
				<Marker longitude={crime.crimeLongitude} latitude={crime.crimeLatitude}>
					<FontAwesomeIcon icon={faMapMarker}  className="text-danger"
										  onClick={() => setPopupInfo(crime)}/>
				</Marker>
			);
		}
	}

	function renderPropertyMarker(property) {
		if(mapboxViewport.zoom >= 16) {
			return (
				<Marker longitude={property.propertyLongitude} latitude={property.propertyLatitude}>
					<FontAwesomeIcon icon={faHome} className="text-dark" onClick={() => setPropPopupInfo(property)}/>
				</Marker>
			);
		}
	}

	//this is for the crime popups
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

	//this is for the property popups
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
					<div>
						<>
							<i><Star propertyId={propPopupInfo.propertyId}/></i>
						</>
					</div>
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
					setMapboxViewport((viewport));
				}}
			>
				{crimes.map((crime) => renderCrimeMarker(crime))}
				{properties.map((property) => renderPropertyMarker(property))}
				{renderPropPopup()}
				{renderPopup()}

			</MapGL>
		</>
	);
};