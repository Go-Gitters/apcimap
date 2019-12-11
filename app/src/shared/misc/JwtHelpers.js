import React, {useState, useEffect} from "react";
import * as jwtDecode from "jwt-decode";

/*
* Custom hooks to grab the jwt and decode jwt data for logged in users.
*
* Author: rlewis37@cnm.edu
* */

export const UseJwt = () => {
	const [jwt, setJwt] = useState(null);

	useEffect(() => {
		setJwt(window.localStorage.getItem("jwt-token"));
	});

	return jwt;
};

export const UseJwtUserUsername = () => {
	const [userUsername, setUserUsername] = useState(null);

	useEffect(() => {
		const token = window.localStorage.getItem("jwt-token");
		if(token !== null) {
			const decodedJwt = jwtDecode(token);
			setUserUsername(decodedJwt.auth.userUsername);
		}
	});

	return userUsername;
};

export const UseJwtUserId = () => {
	const [userId, setUserId] = useState(null);

	useEffect(() => {
		const token = window.localStorage.getItem("jwt-token");
		if(token !== null) {
			const decodedJwt = jwtDecode(token);
			setUserId(decodedJwt.auth.userId);
		}
	});

	return userId;
};