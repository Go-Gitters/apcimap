// For more information on data-driven styles, see https://www.mapbox.com/help/gl-dds-ref/
export const crimeLayer = {
	id: 'crimes',
	type: 'circle',
	paint: {
		'fill-color': '#3288bd',
		'fill-opacity': 1
	}
};

export const dataLayer = {
	id: 'data',
	type: 'fill',
	paint: {
		'fill-color': '#ffffbf',
		'fill-opacity': 0.8
	}
};