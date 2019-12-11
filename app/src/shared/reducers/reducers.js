import {combineReducers} from "redux"
import crimeReducer from "./crimeReducer";
import propertyReducer from "./propertyReducer";
import starReducer from "./starReducer";


export default combineReducers({
	crimes: crimeReducer,
	properties: propertyReducer,
	stars: starReducer
})