import React, {useState} from "react";
import ReactMapGL from 'react-map-gl';


export const Home = () => {
	const [mapboxViewport, setMapboxViewport] = useState({
		width: 800,
		height: 700,
		latitude: 35.1129685,
		longitude: -106.5670637,
		zoom: 12
	});
	return (
		<div className="">
				<div className="d-flex justify-content-center p-5">
					<>
						<ReactMapGL
							className="border border-dark d-inline-block"
							mapboxApiAccessToken='pk.eyJ1Ijoia3lsYWJlbmR0IiwiYSI6ImNrM25oZW5hMjFnYm4zbG40d3ljNWRwMTUifQ.vZe28vwUNPkzafr1vuHDtQ'
							mapStyle={'mapbox://styles/kylabendt/ck3ni0wwo4fxi1cpv0qchtsml'}
							{...mapboxViewport}
							onViewportChange={(viewport) => {
								setMapboxViewport((viewport))
							}}
						/>
					</>
				</div>
		</div>
	);
}