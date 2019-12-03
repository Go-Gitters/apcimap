import React from "react";
import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import {LinkContainer} from "react-router-bootstrap"
import {SignUpModal} from "./sign-up/SignUpModal";
import {SignInModal} from "./sign-in/SigninModal";

<Navbar bg="light" expand="lg">
	<Navbar.Brand href="#home">APCIMAP</Navbar.Brand>
	<Navbar.Toggle aria-controls="basic-navbar-nav" />
	<Navbar.Collapse id="basic-navbar-nav">
	<Nav className="mr-auto">
	<Nav.Link href="#home">Map</Nav.Link>
	<Nav.Link href="#link">Sign Up</Nav.Link>
		<Nav.Link href="#link">Log In</Nav.Link>
		<Nav.Link href="#link">About Us</Nav.Link>
</Nav>
