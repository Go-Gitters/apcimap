import React, {useState, useEffect} from "react";
import {useDispatch, useSelector} from "react-redux";
import {httpConfig} from "../../utils/http-config";
import {UseJwt} from "../../misc/JwtHelpers";
import {handleSessionTimeout} from "../../misc/handle-session-timeout";
import _ from "lodash";


import Badge from "react-bootstrap/Badge";
import Button from "react-bootstrap/Button";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faStar} from "@fortawesome/free-solid-svg-icons";



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
	useEffect(effects, inputs);

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
			<Button variant="outline-primary" size="sm" className={`property-star-btn ${(isStarred !== null ? isStarred : "")}`}
					  onClick={clickStar} disabled={!jwt && true}>
				<FontAwesomeIcon icon="star"/>&nbsp;
			</Button>
		</>
	)
};

// Option 2

// class Stars extends React.Component {
// 	constructor(props) {
// 		super(props);
// 		this.state = {
// 			stars: this.props.stars,
// 		};
// 	}
// 	handleStar = () => {
// 		this.setState(prevState => ({
// 			stars: prevState.stars,
// 		}));
// 	}
// 	render() {
// 		return (
// 			<div>
// 				<button className="star-button" onClick={this.handleStar}>
// 					Star
// 				</button>
// 			</div>
// 		);
// 	}
// }