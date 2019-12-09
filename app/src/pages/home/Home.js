import React, {useState} from "react";
import {Map} from "../../shared/components/map/map";
import {Legend} from "../../shared/components/legend/legend";

//REACT BOOTSTRAP CSS
import 'bootstrap/dist/css/bootstrap.min.css';


export const Home = () => {

	return (
		<>
			<div className="container">
				<div className="row">
					<div className="col-lg-8">
			<div className="d-flex justify-content-center py-3">
				<Map/>
			</div>
					</div>
					<div className="col-lg-4">
			<div className="p-3">
				<Legend/>
			</div>
					</div>
				</div>
			</div>
		</>
	);
}