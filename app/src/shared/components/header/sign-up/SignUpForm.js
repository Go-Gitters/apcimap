import React, {useState} from 'react';
import {httpConfig} from "../../../utils/http-config";
import * as Yup from "yup";
import {Formik} from "formik";
import {SignUpFormContent} from "./SignUpFormContent";


export const SignUpForm = () => {
	const signUp = {
		userEmail: "",
		userPassword: "",
		userPasswordConfirm: "",
		userUsername: "",
	};

	const [status, setStatus] = useState(null);
	const validator = Yup.object().shape({
		userEmail: Yup.string()
			.email("email must be a valid email")
			.required('email is required'),
		userPassword: Yup.string()
			.required("Password is required")
			.min(8, "Password must be at least eight characters"),
		userPasswordConfirm: Yup.string()
			.required("Password Confirm is required")
			.min(8, "Password must be at least eight characters"),
		userUsername: Yup.string()
			.required("username is required")
			.min(3,"username must be at least three characters"),
	});

	const submitSignUp = (values, {resetForm}) => {
		httpConfig.post("/apis/sign-up/", values)
			.then(reply => {
					let {message, type} = reply;
					setStatus({message, type});
					if(reply.status === 200) {
						resetForm();
					}
				}
			);
	};


	return (

		<Formik
			initialValues={signUp}
			onSubmit={submitSignUp}
			validationSchema={validator}
		>
			{SignUpFormContent}
		</Formik>

	)
};