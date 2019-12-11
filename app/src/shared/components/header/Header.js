import React, {useState, useEffect} from "react";
import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import NavDropdown from "react-bootstrap/NavDropdown";
import {LinkContainer} from "react-router-bootstrap";
import {SignUpModal} from "./sign-up/SignUpModal";
import {LoginModal} from "./login/LoginModal";
import "../../../style.css";
import {UseJwt, UseJwtUserId, UseJwtUsername} from "./../../utils/JwtHelper.js";
import {Link} from "react-router-dom";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {httpConfig} from "../../utils/http-config";
import {Button} from "react-bootstrap";

export const Header = (props) => {
	const [token, setToken] = useState(null);
	const username = UseJwtUsername();
	const userId = UseJwtUserId();

	const [jwt, setJwt] = useState(null);

	useEffect(() => {
		setJwt(window.localStorage.getItem("jwt-token"));
	},[jwt]);

	console.log(jwt);
	const displayLogin = () => {
		return (
			<>
				<SignUpModal />
				<LoginModal />
			</>
		)
	};

	const welcome = () => {
		return (
			<>
				Welcome!
			</>
		)
	};

	// const signOut = () => {
	// 	httpConfig.get("/apis/sign-out/")
	// 		.then(reply => {
	// 			let {message, type} = reply;
	// 			if(reply.status === 200) {
	// 				window.localStorage.removeItem("jwt-token");
	// 				setTimeout(() => {
	// 					window.location = "/";
	// 				}, 1500);
	// 			}
	// 		});
	// };
	// <button className="signOut" onClick={signOut()}>
	// 	Sign Out
	// </button>;

	// redirects users to navbar without sign up and sign in function and replaes with "welcome"
	return(
		<Navbar bg="primary" variant="dark">
			<LinkContainer exact to="/" >
				<Navbar.Brand id={"navbar.brand"}>APCIMAP</Navbar.Brand>
			</LinkContainer>
			<Nav className="mr-auto">
				{(jwt !== null && welcome()) || displayLogin()}

			</Nav>

		</Navbar>
)};
