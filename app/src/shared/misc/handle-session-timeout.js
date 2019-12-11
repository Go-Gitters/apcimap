import {httpConfig} from "../utils/http-config";

export const handleSessionTimeout = () => {
	alert("Session inactive. Please log in again.");
	httpConfig.get("apis/signout/")
		.then(reply => {
			let {message, type} = reply;
			if(reply.status === 200) {
				window.localStorage.removeItem("jwt-token");
				console.log(reply);
				setTimeout(() => {
					window.location = '/about';
				}, 1000);
			}
		});
};