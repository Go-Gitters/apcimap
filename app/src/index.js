import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";
import {FourOhFour} from "./pages/four-oh-four/FourOhFour";
import {Home} from "./pages/home/Home";


// import ModalFooter from 'react-bootstrap/ModalFooter';

import {Footer} from "./shared/components/footer/Footer";

const Routing = () => (
	<>
		<BrowserRouter>
			<Switch>
				<Route exact path="/" component={Home}/>
				<Route component={FourOhFour}/>
			</Switch>
			<Footer/>
		</BrowserRouter>
	</>
);
ReactDOM.render(<Routing/>, document.querySelector('#root'));