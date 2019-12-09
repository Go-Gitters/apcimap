import {httpConfig} from "../utils/http-config";

export const getCrimeByCrimeId = (id) => async dispatch => {
	const {data} = await httpConfig('/apis/crime/?crimeId=${id}');
	dispatch({type: "GET_CRIME_BY_CRIME_ID", payload: data });
};

export const getAllCrime = () => async dispatch => {
	const {data} = await httpConfig('/apis/crime/');
	dispatch({type: "GET_ALL_CRIME", payload: data });
};

export const getCrimeByCrimeLocation = (lat, long, distance) => async dispatch => {
	const {data} = await httpConfig(`/apis/crime/?lat=${lat}&long=${long}&distance=${distance}`);
	dispatch({type: "GET_CRIME_BY_CRIME_LOCATION", payload: data });
};