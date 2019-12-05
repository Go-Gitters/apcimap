import React from 'react';
import {Link} from "react-router-dom";

import "../../style.css";

import Col from "react-bootstrap/Col";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Card from "react-bootstrap/Card";

export const Team = () => {
	return (
		<>
			<main className="h-80 mt-5 py-5 d-flex align-items-center">
				<Container fluid="true">
					<Row>
						<Col md>
							<h1 className="team">Our Team</h1>
							<Card bg="secondary" className="border-0 rounded-0 text-white text-shadow-dark">
								<Card.Body>
									<h3>Team Background</h3>
									<p>Go Gitters is a capstone group created from the Fullstack Web Development bootcamp at CNM Ingenuity's Deep Dive Coding.
										The team consists of Lindsey Atencio, Kyla Bendt, and Lisa Lee.</p><br/>
									<p>The Albuquerque Property-Crime Incident Map web application we developed represents our team's capstone
										project.</p><br/>
									<h3>Team Contact Information</h3>
										<ul>
											<li>Lindsey Atencio – lindsey.atencio@gmail.com</li>
											<li>Kyla Bendt – kylabendt@gmail.com</li>
											<li>Lisa Lee – lisa.lee.nm@gmail.com</li>
										</ul>
								</Card.Body>
							</Card>
						</Col>
					</Row>
				</Container>
			</main>
		</>
	)
};