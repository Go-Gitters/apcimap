import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import './style.css';
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";
import {FourOhFour} from "./pages/four-oh-four/FourOhFour";
import {Home} from "./pages/home/Home";
import {Legend} from "./shared/components/legend/legend";


// import ModalFooter from 'react-bootstrap/ModalFooter';

import {Footer} from "./shared/components/footer/Footer";
import {About} from "./pages/about/About";
import {Team} from "./pages/team/Team";

import {Header} from "./shared/components/header/Header";

const Routing = () => (
	<>
		<BrowserRouter>
			<Header/>
			<Switch>
				<Route exact path="/" component={Home}/>
				<Route exact path="/" component={Legend}/>
				<Route exact path="/about" component={About}/>
				<Route exact path="/team" component={Team}/>
				<Route component={FourOhFour}/>
			</Switch>
			<Footer/>
		</BrowserRouter>
	</>
);
ReactDOM.render(Routing() , document.querySelector('#root'));