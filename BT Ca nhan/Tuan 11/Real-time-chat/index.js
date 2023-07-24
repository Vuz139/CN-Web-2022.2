const app = require("express")();
const http = require("http").Server(app);

const io = require("socket.io")(http);

const { faker } = require("@faker-js/faker");

const port = 3000;

app.get("/", (req, res) => {
	res.sendFile(__dirname + "/index.html");
});

let userNamesAndPorts = [];

const getUserByName = (name) => {
	for (const u of userNamesAndPorts) {
		if (u.user !== name) continue;
		return u;
	}
};

io.on("connection", (socket) => {
	const username = faker.person.firstName();
	socket.on("addUser", () => {
		userNamesAndPorts = [];

		io.to(socket.id).emit("username", username);
		io.emit("wakeUp");
	});

	socket.on("chat", (msg, receiverName) => {
		const temp = getUserByName(receiverName);
		if (temp) {
			io.to(temp.port).emit("sendMsg", username, msg);
			io.to(socket.id).emit("sendMsg", username, msg);
		}
	});
	socket.on("online", (username) => {
		userNamesAndPorts.push({ user: username, port: socket.id });
		io.emit("sendUsersOn", userNamesAndPorts);
	});
});

http.listen(port, () => {
	console.log("Server listening on http: ", port);
});
