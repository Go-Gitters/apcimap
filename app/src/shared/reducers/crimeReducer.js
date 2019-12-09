
export default (state = [], action) => {
	switch(action.type) {
		case "GET_ALL_CRIME":
			return action.payload;
		case "GET_CRIME_BY_CRIME_ID":
			return [...state, action.payload];
		case "GET_CRIME_BY_LOCATION":
			return action.payload;
		default:
			return state;
	}
}