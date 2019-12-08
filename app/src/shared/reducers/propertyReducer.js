export default (state = [], action) => {
	switch(action.type) {
		case "GET_ALL_PROPERTIES":
			return action.payload;
		case "GET_PROPERTY_BY_PROPERTY_ID":
			return [...state, action.payload];
		case "GET_PROPERTY_BY_LOCATION":
			return action.payload;
		default:
			return state;
	}
}