import {httpConfig} from "../utils/http-config";

export const getStarsByUserId = (id) => async dispatch => {
	const {data} = await httpConfig(`/apis/star/?userId=${id}`);
	dispatch({type: "GET_STARS_BY_USER_ID", payload: data })
};