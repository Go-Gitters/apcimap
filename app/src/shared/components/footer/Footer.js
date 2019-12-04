import React from "react";

// import {Link} from "react-router-dom";


import "../../../style.css";


import Col from "react-bootstrap/Col";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";

import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faEnvelope} from "@fortawesome/free-solid-svg-icons";
import {library} from "@fortawesome/fontawesome-svg-core";
import {faInfoCircle, faUserFriends} from "@fortawesome/free-solid-svg-icons";
import {faGithub} from "@fortawesome/free-brands-svg-icons";

library.add(faInfoCircle, faGithub, faEnvelope, faUserFriends);

export const Footer = () => (
	<>
		<footer className="page-footer bg-dark fixed-bottom">
			<Container className="container">
				<Row id="icons">
					<Col>
						<a href="https://apcimap.com">
							<i><FontAwesomeIcon icon={faInfoCircle} size="2x" /></i>
						</a>
					</Col>
					<Col>
						<a href="https://github.com/Go-Gitters/apcimap">
							<i><FontAwesomeIcon icon={faGithub} size="2x" /></i>
						</a>
					</Col>
					<Col>
						<a href="mailto:apcimap@gmail.com">
							<i><FontAwesomeIcon icon={faEnvelope} size="2x" /></i>
						</a>
					</Col>
					<Col>
						<a href="https://apcimap.com">
							<i><FontAwesomeIcon icon={faUserFriends} size="2x" /></i>
						</a>
					</Col>
				</Row>
				<Row>
					<Col id="group-name">By Go-Gitters – CNM Deep Dive Bootcamp Group</Col>
				</Row>

			</Container>

			{/*<Row id="footer-links">*/}
			{/*	<Col id="about-link" href="#about-us">About Us</Col>*/}
			{/*	<Col id="github-link" href="#github">Source Code on GitHub</Col>*/}
			{/*</Row>*/}

			{/*<Container fluid="true">*/}
			{/*	<Row>*/}
			{/*		/!*<Col>*!/*/}
			{/*		/!*	<i className="d-none d-lg-block" href="#project-info">APCIMAP Project Information*!/*/}
			{/*		/!*		<FontAwesomeIcon icon={fa}="fas fa-info-circle"</i></a>*!/*/}
			{/*		/!*</Col>*!/*/}
			{/*		<Col>*/}
			{/*			<i className="d-none d-lg-block"*/}
			{/*			<FontAwesomeIcon icon={['fab', 'github']}/> &nbsp;*/}
			{/*			<a href="https://github.com/Go-Gitters/apcimap" className="text-muted" target="_blank"*/}
			{/*				rel="noopener noreferrer">Source Code on GitHub</a>*/}
			{/*		</Col>*/}
			{/*		<Col>*/}
			{/*			<a href="mailto:apcimap@gmail.com" rel="noopener noreferrer" target="_blank">*/}
			{/*				<i className="far fa-envelope"</i></a>*/}
			{/*		</Col>*/}
			{/*		<Col>*/}
			{/*			<i className="d-none d-lg-block" href="#about">About Us*/}
			{/*				<i className="fas fa-user-friends"</i></a>*/}
			{/*		</Col>*/}
			{/*	</Row>*/}

		</footer>
	</>
);