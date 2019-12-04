import React from "react";
import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import {LinkContainer} from "react-router-bootstrap";
import {SignUpModal} from "./sign-up/SignUpModal";
import {LoginModal} from "/LoginModal";

export const MainNav = (props) => {
	return(
		<Navbar bg="primary" variant="dark">
			<LinkContainer exact to="/" >
				<Navbar.Brand>Navbar</Navbar.Brand>
			</LinkContainer>
			<Nav className="mr-auto">
				<LinkContainer exact to="/user">
					<Nav.Link>user</Nav.Link>
				</LinkContainer>
				<SignUpModal/>
				<LoginModal/>
			</Nav>
		</Navbar>
	)
};
