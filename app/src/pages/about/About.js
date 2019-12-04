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
						<Col md>
							<h1 className="about-apcimap">About APCIMap</h1>
							<Card bg="primary" className="border-0 rounded-0 text-white text-shadow-dark">
								<Card.Body>
									<h3>Use Case</h3>
									<p>The Albuquerque Property-Crime Incident Map (APCIMap) application represents our team's capstone
										project. This map application takes datasets from assessed property values in Bernalillo County and Albuquerque Police Department's crime incident reports and overlays them on a map of Bernalillo County. The intention behind this application is to allow users to view properties and the various crimes around them, thereby allowing users to find areas with both lower cost housing and lower crime incidents/types. Additionally, users are able to star properties of interest and store that information for later viewing.</p><br/>
									<h3>Data Sources</h3>
									<h5>Property Value Dataset</h5>
									<p>Property value data comes from the Bernalillo County Assessor's Office. This represents
										the assessed value of the property and may or may not reflect sales value.</p><br/>
									<h5>Crime Incident Dataset</h5>
									<p>Crime incident reports data comes from the City of Albuquerque's police reports from calls
										received by APD (Albuquerque Police Department). This dataset is a rolling 180 days of
										incidents. More information can be found by visiting the city's APD incidents site:
										opendata.cabq.gov/dataset/apd-incidents.</p>
								</Card.Body>
							</Card>
						</Col>
					</Row>
				</Container>
			</main>
		</>
	)
};