import React, {useState} from "react";
import {Button} from "react-bootstrap";
import {Modal} from "react-bootstrap";
import {LoginForm} from "./LoginForm";

//model imports login form which also imports login form content
export const LoginModal = () => {
	const [show, setShow] = useState(false);
	const handleClose = () => setShow(false);
	const handleShow = () => setShow(true);

	//modal button that allows user to sign in
	// modal button close allows users to close the modal
	return (
		<>
			<Button variant="primary" onClick={handleShow}>
				Sign In
			</Button>

			<Modal show={show} onHide={handleClose}>
				<Modal.Header closeButton>
					<Modal.Title>Sign In</Modal.Title>
				</Modal.Header>
				<Modal.Body>
					<LoginForm/>
				</Modal.Body>
				<Modal.Footer>
					<Button variant="secondary" onClick={handleClose}>
						Close
					</Button>
				</Modal.Footer>
			</Modal>
		</>
	);
}