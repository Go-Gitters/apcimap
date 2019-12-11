import React from 'react';
import {Link} from "react-router-dom";

import "../../../style.css";

import Col from "react-bootstrap/Col";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Card from "react-bootstrap/Card";

export const Legend = () => {
	return (
		<>
			<div className="border border-dark px-2">
			<div className="container py-2">
				<div className="row p-2" id="legend-name">
					Assessed Property Value *
				</div>
			</div>

			<div className="container">
				<div className="row">
					<div className="col-2" id="color-box-bracket-1">
					</div>
					<div className="col">
						$0 - $35,100
					</div>
				</div>
			</div>

			<div className="container">
				<div className="row">
					<div className="col-2" id="color-box-bracket-2">
					</div>
					<div className="col">
						$35,101 - $89,696
					</div>
				</div>
			</div>

			<div className="container">
				<div className="row">
					<div className="col-2" id="color-box-bracket-3">
					</div>
					<div className="col">
						$89,697 - $114,076
					</div>
				</div>
			</div>

			<div className="container">
				<div className="row">
					<div className="col-2" id="color-box-bracket-4">
					</div>
					<div className="col">
						$114,077 - $134,200
					</div>
				</div>
			</div>

			<div className="container">
				<div className="row">
					<div className="col-2" id="color-box-bracket-5">
					</div>
					<div className="col">
						$134,201 - $153,742
					</div>
				</div>
			</div>

			<div className="container">
				<div className="row">
					<div className="col-2" id="color-box-bracket-6">
					</div>
					<div className="col">
						$153,743 - $175,159
					</div>
				</div>
			</div>

			<div className="container">
				<div className="row">
					<div className="col-2" id="color-box-bracket-7">
					</div>
					<div className="col">
						$175,160 - $201,500
					</div>
				</div>
			</div>

			<div className="container">
				<div className="row">
					<div className="col-2" id="color-box-bracket-8">
					</div>
					<div className="col">
						$201,501 - $242,700
					</div>
				</div>
			</div>

			<div className="container">
				<div className="row">
					<div className="col-2" id="color-box-bracket-9">
					</div>
					<div className="col">
						$242,701 - $334,319
					</div>
				</div>
			</div>

			<div className="container">
				<div className="row">
					<div className="col-2" id="color-box-bracket-10">
					</div>
					<div className="col">
						$334,320 and up
					</div>
				</div>
			</div>

			<div className="container py-2">
				<div className="row" id="footnote">
					* Range of assessed property values broken into deciles
				</div>
			</div>
			</div>
		</>
	)
};