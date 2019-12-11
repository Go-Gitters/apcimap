import React from "react";

import {Link} from "react-router-dom";


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
		<footer className="page-footer fixed-bottom bg-dark mt-1">
			<Container className="container">
				<div className="d-flex justify-content-center pt-1">
					<Row id="icons pb-0">
						<Col>
							<Link to='/about'>
								<i><FontAwesomeIcon icon={faInfoCircle} size="2x" alt="APCIMap Project Information"/></i>
							</Link>
						</Col>
						<Col>
							<a href="https://github.com/Go-Gitters/apcimap"
							title="Go-Gitters' APCIMap repository on GitHub">
								<i><FontAwesomeIcon icon={faGithub} size="2x"/></i>
							</a>
						</Col>
						<Col>
							<a href="mailto:apcimap@gmail.com"
							title="APCIMap's email">
								<i><FontAwesomeIcon icon={faEnvelope} size="2x"/></i>
							</a>
						</Col>
						<Col>
							<Link to='/team'>
								<i><FontAwesomeIcon icon={faUserFriends} size="2x" alt="APCIMap Team"/></i>
							</Link>
						</Col>
					</Row>
				</div>
				<Row  className="px-0">
					<Col id="group-name" className="px-0">By Go-Gitters – CNM Ingenuity Deep Dive Bootcamp Group</Col>
				</Row>
			</Container>
		</footer>
	</>
);