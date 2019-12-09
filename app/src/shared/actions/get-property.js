import {httpConfig} from "../misc/http-config";

export const getPropertyByPropertyId = (id) => async dispatch => {
	const {data} = await httpConfig('/apis/property/?propertyId=${id}');
	dispatch({type: "GET_CRIME_BY_CRIME_ID", payload: data })
};

export const getAllProperty = () => async dispatch => {
	const {data} = await httpConfig('/apis/property/');
	dispatch({type: "GET_ALL_CRIME", payload: data })
};

export const getPropertyByPropertyLocation = (lat, long, distance) => async dispatch => {
	const {data} = await httpConfig('/apis/property/?lat=${lat}&long=${long}&distance=${distance}');
	dispatch({type: "GET_CRIME_BY_CRIME_LOCATION", payload: data })
};