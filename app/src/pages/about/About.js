import React from 'react';
import {Link} from "react-router-dom";

import "../../style.css";

import Col from "react-bootstrap/Col";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Card from "react-bootstrap/Card";

export const About = () => {
	return (
		<>
			<main className="h-80 mt-5 py-5 d-flex align-items-center">
				<Container fluid="true">
					<Row>
						<Col md={6}>
							<h1>About APCIMap</h1>
						</Col>
						<Col md={6}>
							<Card bg="primary" className="border-0 rounded-0 text-white text-shadow-dark">
								<h2>Data Sources</h2>
								<p>Property value data comes from the Bernalillo County Assessor's Office. This represents the assessed value of the property and may or may not reflect sales value.</p>
								<p>Crime incident reports data comes from the City of Albuquerque's police reports from calls received by APD (Albuquerque Police Department). This dataset is a rolling 180 days of incidents. More information can be found by visiting the city's APD incidents site: opendata.cabq.gov/dataset/apd-incidents.</p>

								<h2>Our Team</h2>
								<p>Go Gitters is a Fullstack Web Development bootcamp at CNM Ingenuity's Deep Dive Coding. The team consists of Lindsey Atencio, Kyla Bendt, and Lisa Lee.</p>
								<p>The Albuquerque Property-Crime Incident Map application represents our teams capstone project.</p>
							</Card>
						</Col>
					</Row>
				</Container>
			</main>
	)
}