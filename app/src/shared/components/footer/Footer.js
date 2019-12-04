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
				<div class="d-flex justify-content-center">
					<Row id="icons">
						<Col>
							<a href="https://apcimap.com">
								<i><FontAwesomeIcon icon={faInfoCircle} size="2x"/></i>
							</a>
						</Col>
						<Col>
							<a href="https://github.com/Go-Gitters/apcimap">
								<i><FontAwesomeIcon icon={faGithub} size="2x"/></i>
							</a>
						</Col>
						<Col>
							<a href="mailto:apcimap@gmail.com">
								<i><FontAwesomeIcon icon={faEnvelope} size="2x"/></i>
							</a>
						</Col>
						<Col>
							<a href="https://apcimap.com">
								<i><FontAwesomeIcon icon={faUserFriends} size="2x"/></i>
							</a>
						</Col>
					</Row>
				</div>
				<Row>
					<Col id="group-name">By Go-Gitters – CNM Ingenuity Deep Dive Bootcamp Group</Col>
				</Row>
			</Container>
		</footer>
	</>
);