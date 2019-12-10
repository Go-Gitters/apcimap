import React, {useState, useEffect} from "react";
import MapGL, {Marker, Source, Layer, Popup} from 'react-map-gl';
import Badge from "react-bootstrap/Badge";
import Button from "react-bootstrap/Button";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faDotCircle, faMapMarker, faStar} from "@fortawesome/free-solid-svg-icons";
import {useDispatch, useSelector} from "react-redux";
import {httpConfig} from "../../utils/http-config";
import {UseJwt} from "../../misc/JwtHelpers";
import {handleSessionTimeout} from "../../misc/handle-session-timeout";
import _ from "lodash";
import {getCrimeByCrimeLocation} from "../../actions/get-crime";
import {getPropertyByPropertyLocation} from "../../actions/get-property";




export const Map = () => {


	const crimes = useSelector(state => (state.crimes ? state.crimes : []));
	const properties = useSelector(state => (state.properties ? state.properties : []));
	const dispatch = useDispatch();
	const effects = () => {
		dispatch(getCrimeByCrimeLocation(35.1129685, -106.5670637, 1));
		dispatch(getPropertyByPropertyLocation(35.1129685, -106.5670637, .1))
	};

	const inputs = [];

	useEffect(effects, inputs);

	const [mapboxViewport, setMapboxViewport] = useState({
		width: "100%",
		height: "80vh",
		latitude: 35.1129685,
		longitude: -106.5670637,
		zoom: 15
	});

	const[popupInfo, setPopupInfo] = useState(null);
	const[propPopupInfo, setPropPopupInfo] = useState(null);


	function renderCrimeMarker(crime) {
		return (
			<Marker longitude={crime.crimeLongitude} latitude={crime.crimeLatitude}>
				<FontAwesomeIcon icon={faMapMarker} size="2x" className="text-danger" onClick={() => setPopupInfo(crime)}/>
			</Marker>
		);
	}

	function renderPropertyMarker(property) {
		return (
			<Marker longitude={property.propertyLongitude} latitude={property.propertyLatitude}>
				<FontAwesomeIcon icon={faDotCircle}  onClick={() => setPropPopupInfo(property)}/>
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
				{crimes.map((crime) => renderCrimeMarker(crime))}
				{properties.map((property) => renderPropertyMarker(property))}
				{renderPropPopup()}
				{renderPopup()}

			</MapGL>
		</>
	);
}

export const Star = ({propertyId, userId}) => {
	// grab the jwt for logged in users
	const jwt = UseJwt();

	/**
	 * the isStarred state variable sets the button color to blue whether or not the logged in user has starred the property
	 *
	 * "active" is a bootstrap class that will be added to the button
	 */

	const [isStarred, setIsStarred] = useState(null);

	// return all logged in user's starred properties from the redux store
	const stars = useSelector(state => (state.stars ? state.stars : []));

	const effects = () => {
		initializeStars(userId);
	};

	// add starred properties to inputs - this informs React that stars are being updated from Redux - ensures proper component rendering
	const inputs = [stars, propertyId, userId];
	useEffects(effects, inputs);

	/**
	 * This function filters over the starred properties from the store, and sets the isStarred state variable to "active" if the logged-in user has already starred the property
	 *
	 * This makes the button red
	 *
	 * See: Lodash https://lodash.com
	 */
	const initializeStars = (userId) => {
		const userStars = stars.filter(star => star.starUserId === userId);
		const starred = _.find(userStars, {'starPropertyId' : propertyId});
		return (_.isEmpty(starred) === false) && setIsStarred("active");
	};

	/**
	 * This function filters over the stars properties from the store, creating a subset of stars for the userId
	 */
	const data = {
		starPropertyId: propertyId,
		starUserId: userId
	};

	const toggleStar = () => {
		setIsStarred(isStarred === null ? "active" : null);
	};

	const submitStar = () => {
		const headers = {'X-JWT-TOKEN': jwt};
		httpConfig.property("apis/star/", data, {
			headers: headers})
			.then(reply => {
				let {message, type} = reply;
				if(reply.status === 200) {
					toggleStar();
				}
				// if there's an issue with a $_SESSION mismatch with xsrf or jwt, alert user and do a sign out
				if(reply.status === 401) {
					handleSessionTimeout();
				}
			});
	};

	const deleteStar = () => {
		const headers = {'X-JWT-TOKEN': jwt};
		httpConfig.delete("apis/star/", {
			headers, data})
			.then(reply => {
				let {message, type} = reply;
				if(reply.status === 200) {
					toggleStar();
				}
				// if there's an issue with a $_SESSION mismatch with xsrf or jwt, alert user and do a sign out
				if(reply.status === 401) {
					handleSessionTimeout();
				}
			});
	};

	// fire this function onclick
	const clickStar = () => {
		(isStarred === "active") ? deleteStar() : submitStar();
	};

	return (
		<>
			<Button variant="outline-primary" size="sm"
					  className={`post-like-btn ${(isStarProperty !== null ? isStarProperty : "")}`}
					  onClick={clickStar} disabled={!jwt && true}>
			<FontAwesomeIcon icon="star"/>&nbsp;
			</Button>
		</>
	)
};