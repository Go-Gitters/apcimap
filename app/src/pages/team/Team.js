import React from 'react';

import "../../style.css";

import Col from "react-bootstrap/Col";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Card from "react-bootstrap/Card";

export const Team = () => {
	return (
		<>
			<main className="h-80 mt-5 py-5 d-flex align-items-center">
				<Container fluid="true" className="mb-5">
					<Row>
						<Col md>
							<h1 className="team">Our Team</h1>
							<Card bg="secondary" className="border-0 rounded-0 text-white text-shadow-dark">
								<Card.Body>
									<h3>Team Background</h3>
									<p>Go Gitters is a capstone group created from the Fullstack Web Development bootcamp at CNM
										Ingenuity's <a className="link"
															href="https://bootcamp-coders.cnm.edu/">Deep Dive Coding</a>.
										The team consists of Lindsey Atencio, Kyla Bendt, and Lisa Lee.</p>
									<p>We developed the Albuquerque Property-Crime Incident Map web application which represents
										our
										team's capstone project. One of the project goals is to demonstrate what we have learned
										in
										the bootcamp by working as a team, coming up with an idea, and building a functioning web
										application. The second goal is to create a minimum viable product – our application can
										be
										used to help users potentially find an affordable home in a low-crime area.</p><br/>
									<h3>Kyla Bendt</h3>
									<p>Kyla has an A.S. in General Science from San Juan College and a B.S. in Mathematics from
										New Mexico Tech. She has spent the last 12 years working with a software company providing
										GIS Mapping software, support and services. She has the cutest two-year-old ever and
										spends her free time mountain biking.</p>
									<p>You can check out her Personal Web Project from the bootcamp at <a
										href="https://custombykyla.com" className="link">custombykyla.com</a>.</p><br/>
									<h3>Lisa Lee</h3>
									<p>Lisa received her college degree in Psychology and Political Science, and spent most of
										her
										career in market research because of her interest in people and what motivates them.</p>
									<br/>
									<h3>Lindsey Atencio</h3>
									<p>Lindsey received her degrees in Political Science and Philosophy. She is working to
										continually diversify and grow her skill set to incorporate them into big-picture
										goals.</p><br/>
									<h3>Team Contact Info</h3>
									<ul>
										<li>Lindsey Atencio – <a href="mailto:lindsey.atencio@gmail.com"
																		 className="link">Email</a></li>
										<li>Kyla Bendt – <a href="mailto:kylabendt@gmail.com" className="link">Email</a> - <a
											href="https://www.linkedin.com/in/kyla-bendt/" className="link">Linked In</a></li>
										<li>Lisa Lee – <a href="mailto:lisa.lee.nm@gmail.com" className="link">Email</a> - <a
											href="https://www.linkedin.com/in/lisa-lee-nm/" className="link">Linked In</a></li>
									</ul>
								</Card.Body>
							</Card>
						</Col>
					</Row>
				</Container>
			</main>
			</>
			);
			};