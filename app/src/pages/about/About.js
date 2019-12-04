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
								<p></p>
							</Card>
						</Col>
					</Row>
				</Container>
			</main>
	)
}