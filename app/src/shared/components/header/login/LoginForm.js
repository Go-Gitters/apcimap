import React from 'react';
import {httpConfig} from "../../../utils/http-config";
import {Formik} from "formik/dist/index";
import * as Yup from "yup";
import {LoginFormContent} from "./LoginFormContent";


export const loginForm = () => {
	//the initial values object defines what the request payload is.
	const login = {
		userEmail: "",
		userHash: ""
	};
	const validator = Yup.object().shape({
		userEmail: Yup.string()
			.email("email must be a valid email")
			.required('email is required'),
		userHash: Yup.string()
			.required("Password is required")
			.min(8, "Password must be at least 8 characters")
	});

	const submitLogin = (values, {resetForm, setStatus}) => {
		httpConfig.post("/apis/login/", values)
			.then(reply => {
				let {message, type} = reply;
				console.log(reply);
				if(reply.status === 200 && reply.headers["x-jwt-token"]) {
					window.localStorage.removeItem("jwt-token");
					window.localStorage.setItem("jwt-token", reply.headers["x-jwt-token"]);
					resetForm();
					setStatus({message, type});

					setTimeout(() => {
						window.location = "/";
					}, 750);

				}
				setStatus({message, type});

			});
	};

	return (
		<Formik
			initialValues={login}
			onSubmit={submitLogin}
			validationSchema={validator}
		>
			{LoginFormContent}
		</Formik>
	)
};