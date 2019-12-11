import React, {useState} from 'react';
import {httpConfig} from "../../../utils/http-config";
import * as Yup from "yup";
import {Formik} from "formik";
import {SignUpFormContent} from "./SignUpFormContent";

//information needed from user in order to sign up
export const SignUpForm = () => {
	const signUp = {
		userEmail: "",
		userPassword: "",
		userPasswordConfirm: "",
		userUsername: "",
	};

//validator ensures that the user email and username are valid, and that the password meets minimum security standards
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

	//submits information inputed by user
	const submitSignUp = (values, {resetForm, setStatus,}) => {
		httpConfig.post("/apis/sign-up/", values)
			.then(reply => {
					let {message, type} = reply;
					if(reply.status === 200) {
						resetForm();
					}
				setStatus({message, type});
				}
			);
	};


	return (

		// form validator
		<Formik
			initialValues={signUp}
			onSubmit={submitSignUp}
			validationSchema={validator}
		>
			{SignUpFormContent}
		</Formik>

	)
};