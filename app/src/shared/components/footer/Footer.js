import React from "react";

import {Link} from "react-router-dom";


// import "../../../index.css";
import "../../../style.css";


import Col from "react-bootstrap/Col";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";

import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";


export const Footer = () => (
	<>
		<footer className="page-footer text-muted py-2 py-md-4">
			<Row id="footer-links">
				<Col id="about-link" href="#about-us">About Us</Col>
				<Col id="github-link" href="#github">Source Code on GitHub</Col>
			</Row>
			<Row>
				<Col id="group-name">by Go-Gitters – a CNM Deep Dive Bootcamp group</Col>
			</Row>
			{/*<Container fluid="true">*/}
			{/*	<Row>*/}
			{/*		<Col className="text-center">*/}
			{/*			<FontAwesomeIcon icon={['fab', 'github']}/> &nbsp;*/}

			{/*			<a href="https://github.com/Go-Gitters/apcimap" className="text-muted" target="_blank"*/}
			{/*				rel="noopener noreferrer">Source Code on GitHub</a>*/}
			{/*		</Col>*/}
			{/*	</Row>*/}
			{/*</Container>*/}
		</footer>
	</>
);