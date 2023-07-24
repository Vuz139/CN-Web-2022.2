import React, { useEffect, useState } from "react";

const Users = () => {
	const [loading, setLoading] = useState(true);
	const [userId, setUserId] = useState(1);
	const [user, setUser] = useState({});
	const fetchUserInfo = async () => {
		try {
			setLoading(true);
			const baseUrl = "https://jsonplaceholder.typicode.com/users";
			const response = await fetch(`${baseUrl}/${userId}`).then((res) =>
				res.json(),
			);

			setUser(response);
		} catch (err) {
			alert("failed to fetch user info");
			console.log(err);
		} finally {
			setLoading(false);
		}
	};

	const handleNext = () => {
		if (userId > 9) {
			return;
		}
		setUserId(userId + 1);
	};
	const handlePrev = () => {
		if (userId < 1) {
			return;
		}
		setUserId(userId - 1);
	};

	useEffect(() => {
		fetchUserInfo();
	}, [userId]);

	return (
		<div style={{ height: "90vh", display: "flex" }}>
			<div style={{ margin: "auto" }}>
				<h1 style={{ textAlign: "center" }}>Welcome to React 101</h1>
				<div className="slider">
					<button disabled={userId === 1} onClick={handlePrev}>
						{"<"}
					</button>
					{loading ? (
						"Loading..."
					) : (
						<div className="user-data">
							<div className="row">
								<span className="label">UserId</span>
								<span>{user.id}</span>
							</div>
							<div className="row">
								<span className="label">UserName</span>
								<span>{user.username}</span>
							</div>
							<div className="row">
								<span className="label">Name</span>
								<span>{user.name}</span>
							</div>
							<div className="row">
								<span className="label">Email</span>
								<span>{user.email}</span>
							</div>
							<div className="row">
								<span className="label">Phone</span>
								<span>{user.phone}</span>
							</div>
							<div className="row">
								<span className="label">Website</span>
								<span>{user.website}</span>
							</div>
						</div>
					)}
					<button disabled={userId === 10} onClick={handleNext}>
						{">"}
					</button>
				</div>
			</div>
		</div>
	);
};

export default Users;
