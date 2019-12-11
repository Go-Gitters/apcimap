export default (state = [], action) => {
	switch(action.type) {
		case "GET_STARS_BY_USER_ID":
			return action.payload;
		default:
			return state;
	}
}